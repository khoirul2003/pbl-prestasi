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
        Schema::create('periods', function (Blueprint $table) {
            $table->id('period_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->string('period_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('academic_year_id')->references('academic_year_id')->on('academic_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};
