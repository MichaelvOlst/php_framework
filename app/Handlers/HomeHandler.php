<?php

namespace App\Handlers;

use App\Models\User;
use App\Jobs\TestJob;
use Core\Application;
use Core\Http\Request;
use Core\Http\Response;

class HomeHandler 
{
    public function __invoke(Request $request, Response $response)
    {
        $app = Application::getInstance();

        $users = $app->get('db')->query('SELECT * FROM users')->all(User::class);
        $user2 = $app->get('db')->prepare('SELECT * FROM users WHERE email = ? LIMIT 1', ['laurablok@gmail.com'])->get(User::class);

        // dump($users);

        dump($app->get('queue')->push(new TestJob()));

        return $response->render('pages/home.twig', ['name' => $user2->fullName()]);
    }
}