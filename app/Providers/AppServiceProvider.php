<?php

namespace App\Providers;

use App\Http\Models\Article;
use App\Http\Models\ArticleClass;
use App\Http\Models\Friends;
use App\Http\Models\Site;
use App\Http\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer(
            '*', 'App\Http\ViewComposers\homeComposer'
        );

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
