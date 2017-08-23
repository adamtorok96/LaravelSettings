<?php

namespace AdamTorok96\LaravelSettings\Facades;


use AdamTorok96\LaravelSettings\SettingsManager;
use Illuminate\Support\Facades\Facade;

class LaravelSettings extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SettingsManager::class;
    }

}