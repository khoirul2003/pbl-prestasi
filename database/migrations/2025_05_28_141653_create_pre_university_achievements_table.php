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
        Schema::create('pre_university_achievements', function (Blueprint $table) {
            $table->id('pre_university_achievement_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('pre_university_achievement_title', 255);
            $table->text('pre_university_achievement_description')->nullable();
            $table->integer('pre_university_achievement_ranking')->nullable();
            $table->enum('pre_university_achievement_level', ['regional', 'nasional', 'internasional'])->nullable();
            $table->string('pre_university_achievement_document', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_university_achievements');
    }
};
