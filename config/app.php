<?php


return [

    'name' => getenv('APP_NAME'),
    'version' => '0.0.1',

    'providers' => [
        'Core\Providers\QueueServiceProvider',
    ]
];