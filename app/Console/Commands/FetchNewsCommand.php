<?php

namespace App\Console\Commands;

use App\Services\Domain\NewsArticleService;
use Illuminate\Console\Command;

class FetchNewsCommand extends Command
{
    protected $newsArticleService;

    public function __construct(NewsArticleService $newsArticleService)
    {
        parent::__construct();
        $this->newsArticleService = $newsArticleService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch
                            {source? : The news source to fetch from (spaceflight, gnews)}
                            {--limit=10 : Maximum number of articles to fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest news from specified or default news source';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $source = $this->argument('source');
        $limit = (int) $this->option('limit');

        try {
            $articles = $this->newsArticleService->fetchAndStoreNews($source, $limit);

            if (empty($articles)) {
                $this->warn('No articles found.');

                return 0;
            }

            return 0;
        } catch (\InvalidArgumentException $e) {
            $this->error($e->getMessage());

            return 1;
        }
    }
}
