<?php

namespace Core\Queue\Drivers;

use Core\Queue\Queue;
use Core\Queue\Interfaces\Job;
use Core\Queue\Interfaces\Driver;

class DatabaseQueue extends Queue implements Driver
{

    public function getName() 
    {
        return 'database';
    }


    public function push(Job $job)
    {
        dump($job);
    }

}