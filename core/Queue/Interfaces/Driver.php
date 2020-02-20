<?php

namespace Core\Queue\Interfaces;

use Core\Queue\Interfaces\Job;

interface Driver 
{
    public function getName();

    public function push(Job $job);
}