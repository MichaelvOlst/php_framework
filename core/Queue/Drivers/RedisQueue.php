<?php

namespace Core\Queue\Drivers;

use Core\Queue\Queue;
use Core\Queue\Interfaces\Job;
use Core\Queue\Interfaces\Driver;

class RedisQueue extends Queue implements Driver
{

    public function getName() 
    {
        return 'redis';
    }


    public function push(Job $job)
    {
        dump($job);
    }

}