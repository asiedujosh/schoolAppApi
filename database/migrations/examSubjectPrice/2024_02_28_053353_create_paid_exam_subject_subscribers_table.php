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
        Schema::create('paid_exam_subject_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('userId');
            $table->string('examId');
            $table->string('yearId');
            $table->string('subjectId');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paid_exam_subject_subscribers');
    }
};
