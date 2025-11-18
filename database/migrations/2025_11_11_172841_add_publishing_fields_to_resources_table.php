<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            // Add missing columns
            $table->boolean('is_published')->default(true)->after('is_public');
            $table->timestamp('published_at')->nullable()->after('is_published');
            $table->json('accessible_grades')->nullable()->after('grade_level');
            $table->json('accessible_sections')->nullable()->after('accessible_grades');
            
            // If subject_id doesn't exist, add it too
            if (!Schema::hasColumn('resources', 'subject_id')) {
                $table->foreignId('subject_id')->nullable()->constrained()->onDelete('set null')->after('subject');
            }
        });
    }

    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn([
                'is_published',
                'published_at',
                'accessible_grades',
                'accessible_sections'
            ]);
            
            if (Schema::hasColumn('resources', 'subject_id')) {
                $table->dropForeign(['subject_id']);
                $table->dropColumn('subject_id');
            }
        });
    }
};