<?php

namespace Core\Traits;

use Core\Providers\TwigServiceProvider;
use Core\Providers\DatabaseServiceProvider;

Trait ProvidersTrait 
{
    protected $defaultProviders = [
        TwigServiceProvider::class,
        DatabaseServiceProvider::class,
    ];

    protected function loadProviders()
    {
        foreach($this->defaultProviders as $provider) {

            $provider = new $provider($this);

            if (method_exists($provider, 'boot')) {
                $this->call([$provider, 'boot']);
            }

            if (method_exists($provider, 'register')) {
                $provider->register();
            }           
        }
    }

}