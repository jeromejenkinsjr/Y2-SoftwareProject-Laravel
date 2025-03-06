<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('shop_items', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->integer('price'); // Price in credits
        $table->string('image'); // e.g. "images/shopitem1.gif"
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('shop_items');
}

};
