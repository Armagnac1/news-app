<?php

namespace App\Providers;

use App\Enums\NewsSource;
use App\Services\News\GNewsSource;
use App\Services\News\NewsSourceInterface;
use App\Services\News\SpaceflightNewsSource;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register individual news sources
        $this->app->bind('news.source.'.NewsSource::SPACEFLIGHT->value, function ($app) {
            return new SpaceflightNewsSource;
        });

        $this->app->bind('news.source.'.NewsSource::GNEWS->value, function ($app) {
            return new GNewsSource;
        });

        // Bind the default news source
        $this->app->bind(NewsSourceInterface::class, function ($app) {
            $defaultSource = config('news.default_source', NewsSource::SPACEFLIGHT->value);

            return $app->make("news.source.{$defaultSource}");
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../../config/news.php' => config_path('news.php'),
        ], 'news-config');
    }
}
