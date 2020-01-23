<?php

use Core\Application;

require_once __DIR__.'/../vendor/autoload.php';

// phpinfo();
// die();

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}


$app = new Application(__DIR__.'/..');

$app->bootstrap();

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// dump($app->get('config'));

// dump($app->get('config')->get('app.name'));


return $app;
