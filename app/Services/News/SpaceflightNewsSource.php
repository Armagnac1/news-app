<?php

namespace App\Services\News;

use App\Enums\NewsSource;

class SpaceflightNewsSource extends AbstractNewsSource
{
    public function __construct()
    {
        $this->baseUrl = NewsSource::SPACEFLIGHT->baseUrl();
        $this->sourceName = NewsSource::SPACEFLIGHT->label();
    }

    /**
     * Fetch latest news articles from Spaceflight News API
     *
     * @param  int  $limit  Maximum number of articles to fetch
     * @return array Array of news articles
     */
    public function fetchLatestNews(int $limit = 10): array
    {
        $response = $this->makeRequest('/articles', [
            'limit' => $limit,
            'ordering' => '-published_at',
        ]);

        if (! $response) {
            return [];
        }

        return array_map(function ($article) {
            return [
                'title' => $article['title'],
                'url' => $article['url'],
                'image_url' => $article['image_url'],
                'news_site' => $article['news_site'],
                'summary' => $article['summary'],
                'published_at' => $article['published_at'],
                'source' => NewsSource::SPACEFLIGHT->value,
            ];
        }, $response['results'] ?? []);
    }
}
