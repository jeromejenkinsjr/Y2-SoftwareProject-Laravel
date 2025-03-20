<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('icons', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Icon name
            $table->string('path'); // Icon image path
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('icons');
    }
};