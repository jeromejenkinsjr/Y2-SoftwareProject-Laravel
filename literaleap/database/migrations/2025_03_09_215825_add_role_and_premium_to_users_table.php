<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Create an enum for roles with a default of 'student'
            $table->enum('role', ['student', 'parent', 'teacher', 'admin'])
                ->default('student')
                ->after('level');

            // Create a boolean column for premium status with a default of false
            $table->boolean('premium')
                ->default(false)
                ->after('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'premium']);
        });
    }
};