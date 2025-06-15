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
        Schema::create('news', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai Primary Key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign Key ke tabel users (penulis berita)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign Key ke tabel categories
            $table->string('title'); // Judul berita
            $table->string('slug')->unique(); // Slug berita, harus unik
            $table->string('image')->nullable(); // Path gambar utama berita, bisa kosong
            $table->longText('body'); // Isi lengkap berita, pakai LONGTEXT untuk artikel panjang
            $table->integer('views')->unsigned()->default(0); // Jumlah tampilan berita, default 0
            $table->timestamp('published_at')->nullable(); // Waktu publikasi berita, bisa kosong (untuk draft)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news'); // Hapus tabel jika migrasi di-rollback
    }
};