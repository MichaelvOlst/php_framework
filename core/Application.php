<?php

namespace Core;

use Core\Http\Request;
use Core\Config\Config;
use Core\Exception\InitException;
use Illuminate\Container\Container;
use Core\Exception\RouteNotFoundException;
use Core\Exception\MethodNotAllowedException;
use Symfony\Component\HttpFoundation\Response;

class Application extends Container {

    protected $root_path;

    protected $app_path;

    protected $config_path;

    protected $view_path;

    const DS = DIRECTORY_SEPARATOR;

    public static $self = null;

    protected $namespaceHandler = 'App\\Handlers\\';

    protected $initObjects = [
        'config' => Config::class,
    ];

    public function __construct(string $root_path) 
    {
        $root_path = realpath(rtrim($root_path, '/\\'));
        $this->root_path = $root_path.self::DS;

        self::$self = &$this;
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


    public function run($request = null)
    {

        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $router) {
            require $this->app_path.'/routes.php';
        });

        $request = $this->make(Request::class);

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());


        dump($routeInfo);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                throw new RouteNotFoundException("Route ".$request->getPathInfo()." not found");
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException("Method ".$request->getMethod()." not allowed");
                // ... 405 Method Not Allowed
                break;
            case \FastRoute\Dispatcher::FOUND:

                $this->handleFoundRoute($routeInfo[1], $routeInfo[2]);
                // $handler = $routeInfo[1];
                // $vars = $routeInfo[2];
                // ... call $handler with $vars
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


    protected function handleFoundRoute($handler, $args)
    {
        if(isset($handler['middleware'])) {
            // call middleware first
        }

        [$class, $method] = explode('@', $handler['handler']);

        // dump($handler['handler']);

        if(!class_exists($class)) {
            dump('test');
        }

        $obj = new $class();

        $response = $this->call([$obj, $method], $args);

        dump($response);


    }

}