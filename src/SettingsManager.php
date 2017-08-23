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

    /**
     * @return JsonSettingDriver
     */
    public function createJsonDriver()
    {
        return new JsonSettingDriver($this->app['config']['settings']);
    }

    /**
     * @return MysqlSettingDriver
     */
    public function createMySqlDriver()
    {
        return new MysqlSettingDriver($this->app['config']['settings']);
    }
}