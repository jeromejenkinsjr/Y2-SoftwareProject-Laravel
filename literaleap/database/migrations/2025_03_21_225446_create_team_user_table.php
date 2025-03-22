<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('team_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Role within the team (e.g., 'admin', 'member')
            $table->string('role')->default('member');
            // Status of membership/invitation: pending, accepted, or declined
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            // Who invited this user (nullable, for invitations)
            $table->foreignId('invited_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('team_user');
    }
};