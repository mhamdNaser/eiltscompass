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
        Schema::create('examings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // This is the foreign key column
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('form_exams_id'); // This is the foreign key column
            $table->foreign('form_exams_id')->references('id')->on('form_exams')->onDelete('cascade'); // Adding foreign key constraint
            $table->string('correction')->default('Click To Correction');
            $table->integer('result')->default(0);
            $table->integer('fullmark')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examings');
    }
};
