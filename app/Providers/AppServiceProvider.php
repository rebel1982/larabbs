<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
        \App\Models\Topic::observe(\App\Observers\TopicObserver::class);
        \App\Models\Link::observe(\App\Observers\LinkObserver::class);
        /**
         * Carbon 是 PHP 知名的 DateTime 操作扩展，Laravel 将其默认集成到了框架中。diffForHumans 是 Carbon 对象提供的方法，默认情况是英文的，如果要使用中文时间提示，则需要对 Carbon 进行本地化设置。对 Carbon 进行本地化的设置很简单，只在 AppServiceProvider 中调用 Carbon 的 setLocale 方法即可，AppServiceProvider 是框架的核心，在 Laravel 启动时，会最先加载该文件。
         */
        
        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
    }
}
