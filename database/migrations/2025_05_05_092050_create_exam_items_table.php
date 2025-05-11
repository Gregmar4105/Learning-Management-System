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
        Schema::create('exam_items', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto-increment
            $table->foreignId('exam_master_id')->constrained('exam_master')->onDelete('cascade'); // FK to exam_master
            $table->text('question');
            $table->string('A', 255);
            $table->string('B', 255);
            $table->string('C', 255);
            $table->string('D', 255);
            $table->enum('question_answer', ['A', 'B', 'C', 'D']);
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_items');
    }
};
