<?php

return [
    'driver'        => 'json',
    
    'cache'         => false,
    'cache_prefix'  => 'settings',

    'json'  => [
        'disk'  => 'local',
        'dir'   => '',
        'file'  => 'settings.json'
    ]
];