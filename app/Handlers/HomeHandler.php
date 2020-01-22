<?php

namespace App\Handlers;

use Core\Http\Request;
use Core\Http\Response;

class HomeHandler 
{
    public function __invoke(Request $request, Response $response, $id, $title = null)
    {
        
        // $response = new Response(
        //     $id .'---'.$title,
        //     Response::HTTP_OK,
        //     ['content-type' => 'text/html']
        // );

        // dump($response);
        

        $response->render('pages/home.twig', ['name' => 'Michael']);

        return $response;
    }
}