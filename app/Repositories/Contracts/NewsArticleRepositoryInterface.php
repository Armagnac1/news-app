<?php

namespace App\Repositories\Contracts;

interface NewsArticleRepositoryInterface
{
    public function getLatestNews(): \Illuminate\Pagination\LengthAwarePaginator;

    public function searchNews(string $query, int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator;
}
