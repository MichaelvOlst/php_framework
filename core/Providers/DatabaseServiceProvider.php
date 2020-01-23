<?php

namespace Core\Providers;

use Core\Database\Connection;
use Core\Providers\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{

    public function register()
    {      
        $db = new Connection($this->app->get('config'));
        
        $this->app->instance('db', $db);
        $this->app->instance(Connection::class, $db);

    }


    



}

