<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('grade_level')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert some default subjects
        DB::table('subjects')->insert([
            ['name' => 'Mathematics', 'code' => 'MATH', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Science', 'code' => 'SCI', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'English', 'code' => 'ENG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'History', 'code' => 'HIST', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Geography', 'code' => 'GEO', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Art', 'code' => 'ART', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Physical Education', 'code' => 'PE', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};