<?php

use Core\Application;

require_once __DIR__.'/../vendor/autoload.php';


$app = new Application(__DIR__.'/..');

$app->bootstrap();


return $app;