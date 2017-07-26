<?php

return [
    'driver'        => 'json',
    
    'autoload'      => true,

    'cache'         => false,
    'cache_prefix'  => 'settings',

    'json'  => [
        'disk'  => 'local',
        'dir'   => '',
        'file'  => 'settings.json'
    ]
];