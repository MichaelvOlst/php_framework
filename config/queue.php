<?php

return [

    'default' => getenv('QUEUE_CONNECTION'),

    'connections' => [

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => getenv('REDIS_QUEUE'),
            'retry_after' => 90,
            'block_for' => null,
        ],

    ],

    'failed' => [
        'driver' => getenv('QUEUE_FAILED_DRIVER', 'database'),
        'database' => getenv('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

];