<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'image',
        'body',
        'published_at',
        'views', // Pastikan 'views' juga ada di fillable jika Anda ingin bisa mengisinya secara massal
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the comments for the news article.
     * Ini mendefinisikan relasi one-to-many: satu berita memiliki banyak komentar.
     * Foreign key 'news_id' di tabel 'comments' akan digunakan untuk menghubungkan ke 'id' berita.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
