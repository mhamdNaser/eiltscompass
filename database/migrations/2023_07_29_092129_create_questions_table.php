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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->string('type');
            $table->string('points')->nullable();
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('form_exams_id');

            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->foreign('form_exams_id')->references('id')->on('form_exams')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
