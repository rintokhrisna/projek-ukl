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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary Key, auto-increment
            $table->string('name'); // Nama pengguna
            $table->string('email')->unique(); // Alamat email, harus unik
            $table->timestamp('email_verified_at')->nullable(); // Waktu verifikasi email, bisa kosong
            $table->string('password'); // Kata sandi terenkripsi
            $table->rememberToken(); // Token untuk fitur "ingat saya"
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Hapus tabel jika migrasi di-rollback
    }
};