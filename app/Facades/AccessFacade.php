<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AccessFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'access';
    }
}