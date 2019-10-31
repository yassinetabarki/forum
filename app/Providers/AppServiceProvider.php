<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
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
        if($this->app->isLocal())
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // todo: we can use view :1
        \View::composer('*',function ($view){
            $channel= Cache::rememberForever('channel',function (){
                return Channel::all();
            });
            $view->with('channels', $channel);
        });
//        View::share('channels', Channel::all());

    }
}
