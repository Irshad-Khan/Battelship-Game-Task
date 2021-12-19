<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class GameHistoryFacades extends Facade
{
    protected static function getFacadeAccessor() { return 'gameHistoryService'; }
}
