<?php


// $router->get('/', ['middleware' => 'test', 'handler' => App\Handlers\HomeHandler::class.'@index']);

$router->get('/', ['middleware' => 'test', 'handler' => App\Handlers\HomeHandler::class]);

$router->get('/user/{id:\d+}[/{title}]', ['middleware' => 'test', 'handler' => App\Handlers\HomeHandler::class]);


// $router->get('/users', 'get_all_users_handler');
// // {id} must be a number (\d+)
// $router->get('/user/{id:\d+}', 'get_user_handler');
// // The /{title} suffix is optional
// $router->get('/articles/{id:\d+}[/{title}]', 'get_article_handler');