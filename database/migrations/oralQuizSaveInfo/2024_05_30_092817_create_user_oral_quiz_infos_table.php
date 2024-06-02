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
        Schema::create('user_oral_quiz_infos', function (Blueprint $table) {
            $table->id();
            $table->string('quizId');
            $table->string('userId');
            $table->string('examsType');
            $table->string('subject');
            $table->string('year');
            $table->string('timer')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_oral_quiz_infos');
    }
};
