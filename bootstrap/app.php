<?php

use Core\Application;

require_once __DIR__.'/../vendor/autoload.php';


$app = new Application(__DIR__.'/..');

$app->bootstrap();

$router = $app->router;
require __DIR__.'/../app/routes.php';

dump($app->get('config'));

dump($app->get('config')->get('app.version'));


return $app;