<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('competition_requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('competition_id');
            $table->enum('request_verified', ['approved', 'rejected', 'pending']);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('competition_id')->references('competition_id')->on('competitions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_requests');
    }
};
