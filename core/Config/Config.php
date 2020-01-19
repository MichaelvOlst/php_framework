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

        // dump($this->config->get('app'));
    }

    public function has($key)
    {
        return isset($this->config[ $key ]) ? true : false;
    }

    public static function load($path)
    {
        $cfg = Application::getInstance('config');

        foreach (new DirectoryIterator($path) as $fileInfo) {
            if($fileInfo->isDot()) {
                continue;
            }

            // dump(require_once $fileInfo->getRealPath());
            $tmpConfig = require_once $fileInfo->getRealPath();
            
            $cfg->set(
                str_replace('.php' ,'', $fileInfo->getFilename()), 
                $tmpConfig
            );

            unset($tmpConfig);
        }
        
        // $dirs = scandir($path);
        // $total = count($dirs);
        // for($i = 2; $i < $total; $i ++)
        // {
        //     if(is_dir( $path . DIRECTORY_SEPARATOR . $dirs [$i] ))
        //     {
        //         Config::load($path . DIRECTORY_SEPARATOR . $dirs [$i]) ;
        //     } else{
        //         $tmp = require_once $path . DIRECTORY_SEPARATOR . $dirs [$i] ;
        //         if(is_array($tmp))
        //         {
        //             $cfg->set(str_replace('.php' ,'',$dirs [$i]), $tmp);
        //         }
        //         unset($tmp);
        //     }
        // }
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