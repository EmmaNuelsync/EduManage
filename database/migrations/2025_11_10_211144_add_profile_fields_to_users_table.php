<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('department')->nullable()->after('phone');
            $table->string('qualification')->nullable()->after('department');
            $table->text('bio')->nullable()->after('qualification');
            $table->text('address')->nullable()->after('bio');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'department', 'qualification', 'bio', 'address']);
        });
    }
};