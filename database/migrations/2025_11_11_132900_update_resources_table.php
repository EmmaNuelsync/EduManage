<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            // Check if table exists, if not create it
            if (!Schema::hasTable('resources')) {
                $table->id();
                $table->string('title');
                $table->enum('type', ['file', 'link']);
                $table->text('description')->nullable();
                $table->string('file_path')->nullable();
                $table->string('file_name')->nullable();
                $table->integer('file_size')->nullable();
                $table->string('external_link')->nullable();
                $table->string('subject')->nullable();
                $table->string('grade_level')->nullable();
                $table->boolean('is_public')->default(true);
                $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
            } else {
                // Add missing columns if table exists
                if (!Schema::hasColumn('resources', 'title')) {
                    $table->string('title');
                }
                if (!Schema::hasColumn('resources', 'type')) {
                    $table->enum('type', ['file', 'link']);
                }
                if (!Schema::hasColumn('resources', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::hasColumn('resources', 'file_path')) {
                    $table->string('file_path')->nullable();
                }
                if (!Schema::hasColumn('resources', 'file_name')) {
                    $table->string('file_name')->nullable();
                }
                if (!Schema::hasColumn('resources', 'file_size')) {
                    $table->integer('file_size')->nullable();
                }
                if (!Schema::hasColumn('resources', 'external_link')) {
                    $table->string('external_link')->nullable();
                }
                if (!Schema::hasColumn('resources', 'subject')) {
                    $table->string('subject')->nullable();
                }
                if (!Schema::hasColumn('resources', 'grade_level')) {
                    $table->string('grade_level')->nullable();
                }
                if (!Schema::hasColumn('resources', 'is_public')) {
                    $table->boolean('is_public')->default(true);
                }
                if (!Schema::hasColumn('resources', 'teacher_id')) {
                    $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
                }
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('resources');
    }
};