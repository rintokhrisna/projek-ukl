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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai Primary Key, auto-increment
            $table->string('name')->unique(); // Nama kategori, harus unik
            $table->string('slug')->unique(); // Slug untuk URL, harus unik dan SEO-friendly
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories'); // Hapus tabel jika migrasi di-rollback
    }
};