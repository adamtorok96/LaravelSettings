<?php

namespace AdamTorok96\LaravelSettings;


use Illuminate\Support\Manager;

class SettingsManager extends Manager
{

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['settings']['driver'];
    }

    public function createJsonDriver()
    {
        return new JsonSettingDriver($this->app['config']['settings']['json']);
    }
}