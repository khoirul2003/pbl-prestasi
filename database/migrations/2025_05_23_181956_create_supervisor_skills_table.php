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
        Schema::create('supervisor_skills', function (Blueprint $table) {
            $table->id('supervisor_skill_id');
            $table->unsignedBigInteger('detail_supervisor_id');
            $table->unsignedBigInteger('skill_id');
            $table->timestamps();

            $table->foreign('detail_supervisor_id')->references('detail_supervisor_id')->on('detail_supervisors')->onDelete('cascade');
            $table->foreign('skill_id')->references('skill_id')->on('skills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisor_skills');
    }
};
