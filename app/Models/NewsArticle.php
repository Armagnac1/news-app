<?php

namespace App\Models;

use App\Enums\NewsSource;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    protected $fillable = [
        'title',
        'content',
        'summary',
        'url',
        'image_url',
        'published_at',
        'source',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'source' => NewsSource::class,
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->orWhere('summary', 'like', "%{$search}%");
        });
    }
}
