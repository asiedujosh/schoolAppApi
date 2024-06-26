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
        Schema::table('exams', function (Blueprint $table) {
            //
            Schema::table('exams', function (Blueprint $table) {
                $table->string('position')->nullable(); // Example of adding a new nullable string field
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            //
            Schema::table('exams', function (Blueprint $table) {
                $table->dropColumn('position'); // Rollback logic (if needed)
            });
        });
    }
};
