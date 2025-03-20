<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('icon_id')->nullable()->constrained('icons')->onDelete('set null');
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['icon_id']);
            $table->dropColumn('icon_id');
        });
    }
};