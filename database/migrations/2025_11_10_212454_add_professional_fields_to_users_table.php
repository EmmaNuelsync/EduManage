<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_id')->nullable()->after('address');
            $table->date('join_date')->nullable()->after('employee_id');
            $table->text('subjects')->nullable()->after('join_date');
            $table->text('classes_assigned')->nullable()->after('subjects');
            $table->string('work_schedule')->nullable()->after('classes_assigned');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'employee_id',
                'join_date', 
                'subjects',
                'classes_assigned',
                'work_schedule'
            ]);
        });
    }
};