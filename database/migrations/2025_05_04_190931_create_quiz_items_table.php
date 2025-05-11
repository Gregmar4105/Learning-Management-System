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
        Schema::create('quiz_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quizzes_id');
            $table->text('question');
            $table->string('A');
            $table->string('B');
            $table->string('C');
            $table->string('D');
            $table->enum('question_answer', ['A', 'B', 'C', 'D']);
            $table->timestamps();

            $table->foreign('quizzes_id')
                  ->references('id')
                  ->on('quizzes')  // Corrected table name
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_items');
    }
};
