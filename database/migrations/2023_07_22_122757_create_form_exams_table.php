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
        Schema::create('form_exams', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
            $table->string('type');
            $table->string('formula');
            $table->integer('exam_time');
            $table->string('status')->default('unActive');
            $table->unsignedBigInteger('writer_id'); // This is the foreign key column
            $table->foreign('writer_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_exams');
    }
};
