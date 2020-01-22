<?php

namespace Core\Providers;

use Core\Application;

abstract class ServiceProvider
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

}

