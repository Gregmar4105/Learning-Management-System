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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropUnique(['quiz_key']); // Remove the unique index
            $table->string('quiz_key')->nullable()->change(); // Keep the column, make sure it's nullable if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('quiz_key')->nullable()->unique()->change(); // Re-add the unique index if you need to rollback
        });
    }
};
