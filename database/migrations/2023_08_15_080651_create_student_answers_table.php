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
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->boolean('stu_ans_value')->nullable();
            $table->unsignedBigInteger('answer_id')->nullable(); // This is the foreign key column
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
            $table->string('answer_content')->nullable();
            $table->unsignedBigInteger('student_examing_id'); // This is the foreign key column
            $table->foreign('student_examing_id')->references('id')->on('examings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};
