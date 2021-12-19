<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class UserFacades extends Facade
{
    protected static function getFacadeAccessor() { return 'userService'; }
}
