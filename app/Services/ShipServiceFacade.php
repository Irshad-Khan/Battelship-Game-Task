<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class ShipServiceFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'shipService'; }
}
