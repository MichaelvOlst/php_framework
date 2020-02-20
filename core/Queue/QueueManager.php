<?php

namespace Core\Queue;

use Core\Queue\Interfaces\Job;
use Core\Queue\Interfaces\Driver;

class QueueManager 
{

    protected $drivers = [];

    protected $defaultDriver;

    public function __construct($defaultDriver = 'sync')
    {
        $this->defaultDriver = $defaultDriver;
    }


    public function register(Driver $driver) 
    {
        $this->drivers[$driver->getName()] = $driver;
    }


    public function getDriver($driver = null)
    {
        return $this->drivers[$driver] ?? $this->getDefaultDriver();
    }
    

    public function push(Job $job, $driver = null)
    {
        return $this->getDriver($driver)->push($job);
    }


    public function getDefaultDriver()
    {
        return $this->drivers[$this->defaultDriver];
    }


}