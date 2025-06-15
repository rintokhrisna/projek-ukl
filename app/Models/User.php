<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // Baris ini DIHAPUS atau DIKOMEN

class User extends Authenticatable
{
    use HasFactory, Notifiable; // HasApiTokens DIHAPUS dari sini

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- Relasi (opsional, tambahkan jika relevan) ---

    /**
     * Get the news articles for the user (penulis).
     */
    // public function news(): HasMany
    // {
    //     return $this->hasMany(News::class);
    // }

    /**
     * Get the comments made by the user.
     */
    // public function comments(): HasMany
    // {
    //     return $this->hasMany(Comment::class);
    // }
}