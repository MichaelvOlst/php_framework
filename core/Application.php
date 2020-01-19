<?php

namespace Core;

use Core\Exception\InitException;
use Illuminate\Container\Container;

class Application extends Container {

    protected $root_dir;

    protected $app_path;

    protected $config_path;

    protected $view_path;

    const DS = DIRECTORY_SEPARATOR;

    public static $self = null;

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
            return static::$self->get($id);
        }

        return static::$self;
    }

 
    public function bootstrap()
    {
        $this->registerPaths();

        $this->loadConfig();

        $this->initRouter();

    }


    protected function registerPaths()
    {
        $this->app_path = $this->root_dir.'app';

        $this->config_path = $this->root_dir.'config';

        $this->view_path = $this->root_dir.'views';
    }



    protected function loadConfig()
    {

    }


    protected function initRouter()
    {

    }


    public function run()
    {
        
    }

}