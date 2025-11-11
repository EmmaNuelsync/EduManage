<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); //For uploaded files
            $table->string('external_link')->nullable(); //For external URLs
            $table->string('type')->default('file'); // file, link, text
            $table->string('subject')->nullable();
            $table->string('grade_level')->nullable();
            $table->boolean('is_public')->default(true);
            $table->integer('download_count')->default(0);
            $table->integer('view_count')->default(0);


            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('set null');
            $table->json('accessible_grades')->nullable(); // Specific grades that can access
            $table->json('accessible_sections')->nullable(); // Specific sections that can access
            $table->boolean('is_published')->default(false); // Control visibility
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
