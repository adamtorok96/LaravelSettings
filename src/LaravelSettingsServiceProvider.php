<?php

namespace AdamTorok96\LaravelSettings;


use Illuminate\Support\ServiceProvider;

class LaravelSettingsServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/config.php', 'settings'
        );

        $this->app->singleton(SettingsManager::class, function ($app) {
            return new SettingsManager($app);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/config.php' => config_path('config.php'),
        ]);
    }

    public function provides()
    {
        return [SettingsManager::class];
    }
}