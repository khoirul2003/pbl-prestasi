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
        Schema::create('recommendation_results', function (Blueprint $table) {
            $table->id('recommendation_result_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('competition_id');
            $table->unsignedBigInteger('detail_supervisor_id')->nullable();
            $table->unsignedBigInteger('detail_student_id')->nullable();
            $table->float('recommendation_result_score');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('competition_id')->references('competition_id')->on('competitions')->onDelete('cascade');
            $table->foreign('detail_supervisor_id')->references('detail_supervisor_id')->on('detail_supervisors')->onDelete('cascade');
            $table->foreign('detail_student_id')->references('detail_student_id')->on('detail_students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendation_results');
    }
};
