<?php

namespace App\Services\News;

use App\Enums\NewsSource;

class GNewsSource extends AbstractNewsSource
{
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = NewsSource::GNEWS->baseUrl();
        $this->sourceName = NewsSource::GNEWS->label();
        $this->apiKey = config('services.gnews.api_key');
    }

    /**
     * Fetch latest news articles from GNews API
     *
     * @param  int  $limit  Maximum number of articles to fetch
     * @return array Array of news articles
     */
    public function fetchLatestNews(int $limit = 10): array
    {
        $response = $this->makeRequest('/top-headlines', [
            'token' => $this->apiKey,
            'max' => $limit,
            'lang' => 'en',
            'country' => 'us',
        ]);

        if (! $response) {
            return [];
        }

        return array_map(function ($article) {
            return [
                'title' => $article['title'],
                'url' => $article['url'],
                'image_url' => $article['image'] ?? null,
                'news_site' => $article['source']['name'],
                'summary' => $article['description'],
                'published_at' => $article['publishedAt'],
                'source' => NewsSource::GNEWS->value,
            ];
        }, $response['articles'] ?? []);
    }
}
