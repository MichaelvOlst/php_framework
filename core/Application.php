<?php

namespace Core;

use Core\Http\Request;
use Core\Config\Config;
use Core\Http\Response;
use Core\Providers\TwigProvider;
use Core\Exception\InitException;
use Illuminate\Container\Container;
use Core\Exception\ClassNotFoundException;
use Core\Exception\RouteNotFoundException;
use Core\Exception\MethodNotAllowedException;

class Application extends Container {

    public $root_path;

    public $app_path;

    public $config_path;

    public $view_path;

    const DS = DIRECTORY_SEPARATOR;

    public static $self = null;

    protected $namespaceHandler = 'App\\Handlers\\';

    protected $initObjects = [
        'config' => Config::class,
    ];


    protected $providers = [
        TwigProvider::class,    
    ];
    

    public function __construct(string $root_path) 
    {
        $root_path = realpath(rtrim($root_path, '/\\'));
        $this->root_path = $root_path.self::DS;

        self::$self = &$this;

        $this->instance('app', $this);
        $this->instance(self::class, $this);
    }


    public static function getInstance($id = null)
    {
        if (is_null(static::$self)) {
            throw new InitException('application has not been bootstraped');
        }

        if (is_string($id)) {
            return static::$self->make($id);
        }

        return static::$self;
    }

 
    public function bootstrap()
    {
        $this->registerPaths();

        $this->registerDefaultObjects();

        $this->loadConfig();

        $this->loadDefaultBindings();

        $this->loadProviders();
    }


    protected function registerPaths()
    {
        $this->app_path = $this->root_path.'app';

        $this->config_path = $this->root_path.'config';

        $this->view_path = $this->root_path.'views';
        
    }


    protected function registerDefaultObjects()
    {
        foreach ($this->initObjects as $key => $val) {
            $this->singleton($key, function() use ($val) {
                return new $val();
            });
        }
    }


    protected function loadConfig()
    {
        if(!is_dir($this->config_path)) {
            throw new InitException("The directory $this->config_path does not exists.");
        }

        Config::load($this->config_path);
    }


    protected function loadDefaultBindings()
    {
        $this->bind(Request::class, function(){
            return Request::createFromGlobals();
        });
    }


    protected function loadProviders()
    {
        foreach($this->providers as $provider) {

            $provider = new $provider($this);

            if (method_exists($provider, 'boot')) {
                $this->call([$provider, 'boot']);
            }

            if (method_exists($provider, 'register')) {
                $provider->register();
            }           
        }


    }


    public function run($request = null)
    {

        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $router) {
            require $this->app_path.'/routes.php';
        });

        $request = $this->make(Request::class);

        [$uriFound, $handler, $vars] = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());


        switch ($uriFound) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                throw new RouteNotFoundException("Route ".$request->getPathInfo()." not found");
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException("Method ".$request->getMethod()." not allowed");
                // ... 405 Method Not Allowed
                break;
            case \FastRoute\Dispatcher::FOUND:
                $this->handleFoundRoute($handler, $vars);
                break;
        }


        // $response = $this->dispatch($request);
        // if ($response instanceof Response) {
        //     $response->send();
        // } else {
        //     echo (string) $response;handleFoundRoute
        // }
        // if (count($this->middleware) > 0) {
        //     $this->callTerminableMiddleware($response);
        // }
    }


    protected function handleFoundRoute($action, $vars = null)
    {
        if(isset($action['middleware'])) {
            // call middleware first
        }

        if(!strstr($action['handler'], '@')) {
            $action['handler'] = $action['handler'].'@__invoke';
        }

        [$class, $method] = explode('@', $action['handler']);

        // dump($handler['handler']);

        if(!class_exists($class)) {
            throw new ClassNotFoundException("Class $class does not exists");
        }

        // dump($vars);

        $obj = new $class();

        $response = $this->call([$obj, $method], $vars);

         if ($response instanceof Response) {
            $response->send();
        } else {
            echo (string) $response;
        }


    }

}