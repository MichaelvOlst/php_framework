<?php

namespace Core\Config;

use Core\Application;
use DirectoryIterator;
use Core\Helper\Collection;


class Config
{
    public $config = [];

    public function get($key)
    {
        if ($this->has($key)) {
            return $this->config[$key];
        }

        if( strstr($key ,'.') !== false) {
            $keys = explode('.',$key);
            if( ($collect = $this->get($keys[0])) === null) {
                return null ;
            } else{
                unset($keys[0]) ;
                return $collect->get(implode('.',$keys));
            }
        }
        return null;
    }

    public function set($key, $value)
    {
        if(is_array($value)) {
            $this->config[$key] = new Collection($value);
        } else {
            $this->config[$key] = [$value];
        }
    }

    public function has($key)
    {
        return isset($this->config[ $key ]) ? true : false;
    }

    public function load($path)
    {
        // $cfg = Application::getInstance('config');

        foreach (new DirectoryIterator($path) as $fileInfo) {
            if($fileInfo->isDot()) {
                continue;
            }

            // dump(require_once $fileInfo->getRealPath());
            $tmpConfig = require_once $fileInfo->getRealPath();
            
            $this->set(
                str_replace('.php' ,'', $fileInfo->getFilename()), 
                $tmpConfig
            );

            unset($tmpConfig);
        }
    }

    /**
     * getSession => $config ['session'] [$key] ;
     * @param $key
     * @return null
     */
    public function __get($key)
    {
        if($this->has($key)){
            return $this->get($key);
        }
        return null ;
    }
}