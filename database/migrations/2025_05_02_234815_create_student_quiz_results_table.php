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
        Schema::create('student_quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Student who took the quiz
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade'); // The specific quiz taken
            $table->integer('correct_answers')->default(0);
            $table->integer('total_questions')->default(0);
            $table->float('score')->nullable(); // You can calculate the score here (correct_answers / total_questions) * 100
            $table->timestamps();

            $table->unique(['user_id', 'quiz_id']); // Ensure a student can only have one result per quiz
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_quiz_results');
    }
};