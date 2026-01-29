<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->year('publication_year');
            $table->string('cover_image')->nullable(); // Path gambar cover
            $table->string('file_path'); // Path file PDF
            $table->unsignedBigInteger('uploaded_by'); // Siapa yang upload (Admin)
            $table->timestamps();

            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};