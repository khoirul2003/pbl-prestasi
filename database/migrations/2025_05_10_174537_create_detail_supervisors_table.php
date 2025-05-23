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
        Schema::create('detail_supervisors', function (Blueprint $table) {
            $table->id('detail_supervisor_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('department_id');
            $table->string('detail_supervisor_nip', 255)->unique();
            $table->enum('detail_supervisor_gender', ['female', 'male']);
            $table->date('detail_supervisor_dob');
            $table->string('detail_supervisor_address', 255);
            $table->string('detail_supervisor_phone_no', 255);
            $table->string('detail_supervisor_email', 255);
            $table->string('detail_supervisor_photo', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_supervisors');
    }
};
