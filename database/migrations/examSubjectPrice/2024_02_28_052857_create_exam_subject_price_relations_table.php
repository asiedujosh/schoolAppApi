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
            $table->string('examId');
            $table->string('yearId');
            $table->string('subjectId');
            $table->string('offerType');
            $table->string('price')->nullable();
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
