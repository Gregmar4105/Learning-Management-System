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
        Schema::create('activity_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_post_id');
            $table->unsignedBigInteger('user_id'); // Assuming you want to know which student uploaded it
            $table->string('title');
            $table->text('description'); // Optional description for the upload
            $table->string('file_path');
            $table->string('original_name')->nullable(); // Store the original filename the user uploaded
            $table->timestamps();

            // Define the foreign key constraint to assignment_posts table
            $table->foreign('activity_post_id')
                  ->references('id')
                  ->on('activity_posts')
                  ->onDelete('cascade'); // If an assignment post is deleted, its uploads are also deleted

            // Define the foreign key constraint to users table (for the student who uploaded)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // If a user is deleted, their uploads might also be deleted (adjust as needed)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_uploads');
    }
};
