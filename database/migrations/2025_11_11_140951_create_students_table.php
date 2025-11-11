<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Personal Information
            $table->string('student_id')->unique();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('parent_guardian')->nullable();
            $table->text('medical_info')->nullable();
            $table->string('profile_picture')->nullable();
            
            // Academic Information
            $table->string('grade_level')->nullable();
            $table->string('section')->nullable();
            $table->string('academic_year')->nullable();
            $table->string('homeroom_teacher')->nullable();
            $table->text('subjects')->nullable();
            $table->date('enrollment_date')->nullable();
            
            // Academic Performance
            $table->decimal('gpa', 3, 2)->nullable();
            $table->integer('attendance_rate')->nullable();
            $table->integer('completed_assignments')->default(0);
            $table->integer('total_assignments')->default(0);
            $table->integer('class_rank')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};