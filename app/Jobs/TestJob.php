<?php

namespace App\Jobs;

use Core\Queue\Interfaces\Job;

class TestJob implements Job
{

    public function fire()
    {
        return 'fire test job';
    }

}