<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('shop_items', function (Blueprint $table) {
            $table->string('type')->default('item')->after('price');
        });
    }

    public function down()
    {
        Schema::table('shop_items', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};