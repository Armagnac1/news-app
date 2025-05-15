<?php

namespace App\Providers;

use App\Repositories\Contracts\NewsArticleRepositoryInterface;
use App\Repositories\Eloquent\NewsArticleEloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            NewsArticleRepositoryInterface::class,
            NewsArticleEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
