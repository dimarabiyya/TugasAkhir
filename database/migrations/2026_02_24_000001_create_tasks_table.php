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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('max_score')->default(100);
            $table->string('file_types')->nullable()->comment('Allowed file types: png,jpg,pdf,etc');
            $table->integer('max_file_size')->nullable()->comment('Max file size in MB');
            $table->boolean('allow_link')->default(true)->comment('Allow URL submission');
            $table->boolean('allow_file')->default(true)->comment('Allow file upload');
            $table->boolean('allow_multiple_submissions')->default(false);
            $table->dateTime('due_date')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

