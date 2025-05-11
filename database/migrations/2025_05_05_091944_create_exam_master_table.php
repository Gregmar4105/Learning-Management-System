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
        Schema::create('exam_master', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto-increment
            $table->string('title', 255);
            $table->string('exam_key', 255)->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // assumes 'users' table
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // assumes 'courses' table
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_master');
    }
};
