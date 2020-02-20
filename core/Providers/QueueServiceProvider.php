<?php

namespace Core\Providers;

use Core\Queue\QueueManager;
use Core\Queue\Drivers\SyncQueue;
use Core\Queue\Drivers\RedisQueue;
use Core\Providers\ServiceProvider;
use Core\Queue\Drivers\DatabaseQueue;

class QueueServiceProvider extends ServiceProvider
{

    public function register()
    {      
        $this->app->singleton('queue', function(){
            $queue = new QueueManager();
            $queue->register(new SyncQueue());
            $queue->register(new RedisQueue());
            $queue->register(new DatabaseQueue());
            return $queue;
        });
    }



}


