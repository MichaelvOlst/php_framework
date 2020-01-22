<?php

namespace Core\Providers;

use Core\Providers\ServiceProvider;

class TwigProvider extends ServiceProvider
{

    public function register()
    {
       
        
        $this->app->bind('twig', function(){
            $loader = new \Twig\Loader\FilesystemLoader($this->app->view_path);
            $twig = new \Twig\Environment($loader, [
                // 'cache' => '/path/to/compilation_cache',
            ]);

            return $twig;
        });
    }

}

