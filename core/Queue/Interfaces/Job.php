<?php

namespace Core\Queue\Interfaces;

interface Job 
{
    public function fire();
}