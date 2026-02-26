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
        Schema::create('task_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_submission_id')->constrained()->onDelete('cascade');
            $table->foreignId('grader_id')->constrained('users')->onDelete('cascade');
            $table->integer('score')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_grades');
    }
};
