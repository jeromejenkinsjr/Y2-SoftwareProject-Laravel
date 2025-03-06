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
    Schema::create('shop_item_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('shop_item_id')->constrained()->onDelete('cascade');
        $table->timestamp('purchased_at')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('shop_item_user');
}

};
