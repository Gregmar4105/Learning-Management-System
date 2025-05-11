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
        Schema::table('quiz_masters', function (Blueprint $table) {
            $table->dropColumn(['A', 'B', 'C', 'D']); // Drop these columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        {
            Schema::table('quiz_masters', function (Blueprint $table) {
                //  If you need to rollback, you might add the columns back (optional)
                //   $table->string('A')->nullable();
                //   $table->string('B')->nullable();
                //    $table->string('C')->nullable();
                //    $table->string('D')->nullable();
            });
        }
};
