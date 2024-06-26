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
        Schema::create('exam_subject_price_relations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('examId');
            $table->string('subjectId');
            $table->string('offerType');
            $table->string('examTime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_subject_price_relations');
    }
};
