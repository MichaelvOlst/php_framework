<?php

namespace App\Models;

class User 
{


    public function fullName()
    {
        return $this->email.' '.$this->username;
    }


}