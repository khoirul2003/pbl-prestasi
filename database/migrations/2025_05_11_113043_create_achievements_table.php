<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id('achievement_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->string('achievement_title', 255);
            $table->text('achievement_description');
            $table->integer('achievement_ranking');
            $table->enum('achievement_level', ['regional', 'nasional', 'internasional']);
            $table->string('achievement_document', 255)->nullable();
            $table->enum('achievement_verified', ['approved', 'rejected', 'pending']);
            $table->text('achievement_reject_description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
