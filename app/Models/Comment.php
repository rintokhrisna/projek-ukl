<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'news_id',
        'parent_id',
        'guest_name',
        'guest_email',
        'body',
        'approved',
    ];

    /**
     * Get the news article that owns the comment.
     */
    public function news()
    {
        return $this->belongsTo(News::class);
    }

    /**
     * Get the parent comment (if this is a reply).
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the replies for the comment.
     */
    public function replies()
    {
        // Recursively load replies of replies
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }
}
