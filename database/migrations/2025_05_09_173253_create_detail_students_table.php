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
        Schema::create('detail_students', function (Blueprint $table) {
            $table->id('detail_student_id');
            $table->unsignedBigInteger('study_program_id');
            $table->string('detail_student_nim', 255)->unique();
            $table->enum('detail_student_gender', ['female', 'male']);
            $table->date('detail_student_dob');
            $table->string('detail_student_address', 255);
            $table->string('detail_student_phone_no', 255);
            $table->string('detail_student_email', 255);
            $table->string('detail_student_photo', 255);
            $table->timestamps();

            $table->foreign('study_program_id')->references('study_program_id')->on('study_programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_students');
    }
};
