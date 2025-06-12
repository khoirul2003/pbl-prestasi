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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id('competition_id');
            $table->unsignedBigInteger('category_id');
            $table->string('competition_tittle', 255);
            $table->text('competition_description');
            $table->string('competition_organizer', 255);
            $table->enum('competition_level', ['regional', 'nasional', 'internasional']);
            $table->date('competition_registration_start');
            $table->date('competition_registration_deadline');
            $table->string('competition_registration_link', 255);
            $table->string('competition_document', 255)->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
