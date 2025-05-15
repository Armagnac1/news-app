<?php

namespace App\Repositories\Eloquent;

use App\Models\NewsArticle;
use App\Repositories\Contracts\NewsArticleRepositoryInterface;

class NewsArticleEloquentRepository extends AbstractEloquentRepository implements NewsArticleRepositoryInterface
{
    public function __construct(NewsArticle $model)
    {
        parent::__construct($model);
    }

    public function getLatestNews(int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function searchNews(string $query, int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhere('summary', 'like', "%{$query}%");
            })
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function findWithSource(NewsArticle $article): NewsArticle
    {
        return $article->load('source');
    }
}
