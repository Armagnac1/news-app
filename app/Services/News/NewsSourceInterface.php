<?php

namespace App\Services\News;

interface NewsSourceInterface
{
    /**
     * Fetch latest news articles from the source
     *
     * @param  int  $limit  Maximum number of articles to fetch
     * @return array Array of news articles
     */
    public function fetchLatestNews(int $limit = 10): array;

    /**
     * Get the name of the news source
     */
    public function getSourceName(): string;

    /**
     * Get the base URL of the news source
     */
    public function getBaseUrl(): string;
}
