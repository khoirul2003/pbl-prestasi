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
        Schema::create('student_periods', function (Blueprint $table) {
            $table->id('student_period_id');
            $table->unsignedBigInteger('period_id');
            $table->unsignedBigInteger('detail_student_id');
            $table->decimal('ipk');
            $table->timestamps();

            $table->foreign('period_id')->references('period_id')->on('periods')->onDelete('cascade');
            $table->foreign('detail_student_id')->references('detail_student_id')->on('detail_students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_periods');
    }
};
