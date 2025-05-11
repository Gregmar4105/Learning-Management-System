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
        Schema::table('quiz_items', function (Blueprint $table) {
            $table->renameColumn('quizzes_id', 'quiz_master_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_items', function (Blueprint $table) {
            $table->renameColumn('quiz_master_id', 'quizzes_id'); // Corrected in down as well
        });
    }
};
