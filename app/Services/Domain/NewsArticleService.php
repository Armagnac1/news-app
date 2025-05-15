<?php

namespace App\Services\Domain;

use App\Repositories\Contracts\NewsArticleRepositoryInterface;

class NewsArticleService extends AbstractDomainService
{
    public function __construct(NewsArticleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getLatestNews(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->repository->getLatestNews();
    }

    public function searchNews(string $query): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->repository->searchNews($query);
    }

    public function getAvailableSources(): array
    {
        return array_map(
            fn (\App\Enums\NewsSource $source) => $source->value,
            \App\Enums\NewsSource::cases()
        );
    }

    /**
     * Fetch and store news articles from a specified source
     *
     * @param  string|null  $source  The news source to fetch from
     * @param  int  $limit  Maximum number of articles to fetch
     * @return array Array of created news articles
     */
    public function fetchAndStoreNews(?string $source = null, int $limit = 10): array
    {
        if ($source) {
            try {
                $newsSourceEnum = \App\Enums\NewsSource::from($source);
            } catch (\ValueError $e) {
                throw new \InvalidArgumentException(
                    'Invalid news source. Supported sources: '.
                    implode(', ', array_column(\App\Enums\NewsSource::cases(), 'value'))
                );
            }

            $newsSource = app()->make("news.source.{$newsSourceEnum->value}");
        } else {
            $defaultSource = config('news.default_source', \App\Enums\NewsSource::SPACEFLIGHT->value);
            $newsSourceEnum = \App\Enums\NewsSource::from($defaultSource);
            $newsSource = app()->make(NewsSourceInterface::class);
        }

        $articles = $newsSource->fetchLatestNews($limit);

        if (empty($articles)) {
            return [];
        }

        $createdArticles = [];
        foreach ($articles as $article) {
            $newsArticle = $this->create([
                'title' => $article['title'],
                'content' => $article['summary'] ?? '',
                'summary' => $article['summary'] ?? null,
                'url' => $article['url'],
                'image_url' => $article['image_url'] ?? null,
                'published_at' => $article['published_at'],
                'source' => $newsSourceEnum->value,
            ]);

            broadcast(new \App\Events\NewsArticleCreated($newsArticle));
            $createdArticles[] = $newsArticle;
        }

        return $createdArticles;
    }
}
