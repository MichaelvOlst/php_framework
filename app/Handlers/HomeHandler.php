<?php

namespace App\Handlers;

use Core\Application;
use Core\Http\Request;
use Core\Http\Response;

class HomeHandler 
{
    public function __invoke(Request $request, Response $response)
    {
        $app = Application::getInstance();

        dump($app->get('db'));

        return $response->render('pages/home.twig', ['name' => 'Michael']);
    }
}