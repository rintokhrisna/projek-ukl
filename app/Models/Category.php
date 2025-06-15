<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany untuk relasi

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    // --- Relasi ---

    /**
     * Get the news articles for the category.
     * Satu kategori bisa memiliki banyak berita.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}