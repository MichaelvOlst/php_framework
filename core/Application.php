<?php

namespace Core;

use Core\Config\Config;
use Core\Exception\InitException;
use Illuminate\Container\Container;

class Application extends Container {

    protected $root_path;

    protected $app_path;

    protected $config_path;

    protected $view_path;

    const DS = DIRECTORY_SEPARATOR;

    public static $self = null;

    protected $initObjects = [
        'config' => Config::class,
        // 'router' => Router::class,
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

        $this->initRouter();

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


    protected function initRouter()
    {

    }


    public function run()
    {
        
    }

}