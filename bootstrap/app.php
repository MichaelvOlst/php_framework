<?php

use Core\Application;

require_once __DIR__.'/../vendor/autoload.php';


$app = new Application(__DIR__.'/..');

$app->bootstrap();


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// dump($app->get('config'));

// dump($app->get('config')->get('app.version'));


return $app;