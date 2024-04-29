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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('examId');
            $table->string('yearId');
            $table->string('subjectId');
            $table->string('topicId')->nullable();
            $table->longText('question');
            $table->integer('questionNo');
            $table->string('questionEquation')->nullable();
            $table->longText("imageOptions")->nullable();
            $table->string('options')->nullable();
            $table->string('optionsWithEquation')->nullable();
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
        Schema::dropIfExists('questions');
    }
};
