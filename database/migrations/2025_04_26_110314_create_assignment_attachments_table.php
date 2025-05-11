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
        Schema::create('assignment_attachments', function (Blueprint $table) {
            $table->id();
            // Foreign key linking to the assignment_posts table
            $table->foreignId('assignment_post_id')
                  ->constrained('assignment_posts') // Ensures the post exists
                  ->onDelete('cascade'); // If an assignment post is deleted, delete its attachments too

            $table->string('file_path'); // Path where the file is stored (e.g., 'assignment_attachments/xyz.pdf')
            $table->string('original_name')->nullable(); // Store the original filename the user uploaded
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_attachments');
    }
};
