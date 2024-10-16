<?php

namespace App\Providers;

use App\Models\Tag;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
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
        $this->app->bind(PostRepository::class, function ($app) {
            return new PostRepository();
        });

        $this->app->bind(TagRepository::class, function ($app) {
            return new TagRepository(new Tag());
        });
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
