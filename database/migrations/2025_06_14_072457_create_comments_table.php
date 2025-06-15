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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai Primary Key
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Foreign Key ke tabel users (pengguna yang berkomentar), bisa NULL jika komentar anonim. Jika user dihapus, user_id di comment akan jadi NULL
            $table->foreignId('news_id')->constrained('news')->onDelete('cascade'); // Foreign Key ke tabel news (artikel yang dikomentari). Jika berita dihapus, komentar ikut terhapus
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // Foreign Key ke dirinya sendiri (untuk balasan komentar), bisa NULL. Jika parent comment dihapus, reply-nya juga terhapus
            $table->string('guest_name')->nullable(); // Nama tamu jika tidak login
            $table->string('guest_email')->nullable(); // Email tamu jika tidak login
            $table->text('body'); // Isi komentar
            $table->boolean('approved')->default(true); // Status persetujuan komentar (TRUE = disetujui, FALSE = belum disetujui/perlu moderasi)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments'); // Hapus tabel jika migrasi di-rollback
    }
};