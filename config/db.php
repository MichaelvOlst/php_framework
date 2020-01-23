<?php

return [
    'host' => getenv('DB_HOST'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'database' => getenv('DB_DATABASE'),
    'port' => getenv('DB_PORT'),
    'charset' => 'utf8mb4',
];