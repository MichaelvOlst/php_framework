<?php

namespace App\Handlers;

use Core\Http\Request;

class HomeHandler 
{
    public function index(Request $request)
    {
        return $request->getPathInfo();
    }
}