<?php

namespace AdamTorok96\LaravelSettings\Facades;


use Illuminate\Support\Facades\Facade;

class LaravelSettings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }

}