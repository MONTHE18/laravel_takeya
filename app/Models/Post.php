<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
        'published_at',
    ];

    protected $casts = [
    'published_at' => 'datetime',
    ];

      
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
