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
        Schema::create('performance_task_posts', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("body");

            $table->unsignedBigInteger('user_id');//creates the foreign key column
            $table->unsignedBigInteger('course_id');//creates the foreign key column
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // all records according to the user in foreign key will be deleted.

            $table->foreign('course_id')
                  ->references('id')
                  ->on('courses')
                  ->onDelete('cascade'); // all records according to the user in foreign key will be deleted.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_task_posts');
    }
};
