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
            $settingsManager = new SettingsManager($app);

            if( $app['config']['settings']['autoload'] ) {
                $settingsManager->load();
            }

            return $settingsManager;
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/config.php' => config_path('settings.php'),
        ]);
    }

    public function provides()
    {
        return [SettingsManager::class];
    }
}