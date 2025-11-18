<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, drop the problematic foreign key if it exists
        Schema::table('resources', function (Blueprint $table) {
            // Check if the foreign key exists before trying to drop it
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('resources');
            
            if (array_key_exists('resources_subject_id_foreign', $indexes)) {
                $table->dropForeign(['subject_id']);
            }
            
            // Now add the columns without the foreign key first
            if (!Schema::hasColumn('resources', 'is_published')) {
                $table->boolean('is_published')->default(true)->after('is_public');
            }
            
            if (!Schema::hasColumn('resources', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            }
            
            if (!Schema::hasColumn('resources', 'accessible_grades')) {
                $table->json('accessible_grades')->nullable()->after('grade_level');
            }
            
            if (!Schema::hasColumn('resources', 'accessible_sections')) {
                $table->json('accessible_sections')->nullable()->after('accessible_grades');
            }
            
            // Add subject_id without foreign key first
            if (!Schema::hasColumn('resources', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('subject');
            }
        });

        // Now add the foreign key constraint in a separate operation
        Schema::table('resources', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropColumn([
                'is_published',
                'published_at',
                'accessible_grades',
                'accessible_sections',
                'subject_id'
            ]);
        });
    }
};