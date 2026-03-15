<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini

return new class extends Migration
{
    public function up(): void
    {
        // Matikan pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::dropIfExists('counseling_sessions');
        
        Schema::create('counseling_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        // Hidupkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('counseling_sessions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};