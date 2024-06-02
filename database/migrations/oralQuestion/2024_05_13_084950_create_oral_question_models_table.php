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
        Schema::create('oral_question_models', function (Blueprint $table) {
            $table->id();
            $table->string('examId');
            $table->string('yearId');
            $table->string('subjectId');
            $table->string('topicId')->nullable();
            $table->longText('comment')->nullable();
            $table->longText('question');
            $table->string('mimeType');
            $table->integer('questionNo');
            $table->longText('options')->nullable();
            $table->string('answer');
            $table->string('hints')->nullable();
            $table->string('publisher');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oral_question_models');
    }
};
