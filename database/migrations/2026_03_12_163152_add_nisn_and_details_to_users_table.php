<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom NISN di sini
            $table->string('nisn')->unique()->nullable()->after('id');
            
            // Jika mau sekalian tambah phone, avatar, level:
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->string('level')->default('user')->after('avatar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom jika kita melakukan rollback
            $table->dropColumn(['nisn', 'phone', 'avatar', 'level']);
        });
    }
};