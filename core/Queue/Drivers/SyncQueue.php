<?php

namespace Core\Queue\Drivers;

use Core\Queue\Queue;
use Core\Queue\Interfaces\Job;
use Core\Queue\Interfaces\Driver;

class SyncQueue extends Queue implements Driver
{

    public function getName() 
    {
        return 'sync';
    }


    public function push(Job $job)
    {
        return $job->fire();
    }

}