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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('detail_student_id')->nullable();
            $table->unsignedBigInteger('detail_supervisor_id')->nullable();
            $table->string('user_name', 255);
            $table->string('user_username', 255);
            $table->string('user_password', 255);
            $table->timestamps();

            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            $table->foreign('detail_student_id')->references('detail_student_id')->on('detail_students')->onDelete('set null');
            $table->foreign('detail_supervisor_id')->references('detail_supervisor_id')->on('detail_supervisors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
