<?php

namespace App\Repositories;

use App\Contracts\GuessInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Ship;
use App\Services\ShipServiceFacade;
use App\Services\UserFacades;
use Illuminate\Support\Facades\DB;

class GuessRepository implements GuessInterface
{
    protected $xAxis = ['1','2','3','4','5','6','7','8','9','10'];
    protected $yAxis = ['A','B','C','D','E','F','G','H','I','J'];

    /**
     * It is used to create rendom ship for computer. So, that user can guess.
     */
    public function index()
    {
        ShipServiceFacade::truncateShip();
        UserFacades::initilizeTotalShot();

        /**
         * Create BattelShip
         */
        $coordinateY = $this->yAxis[array_rand($this->yAxis)];
        for($i=1; $i< count($this->xAxis)/2; $i++){
            Ship::create([
                'ship_type' => 'Battleship',
                'coordinates' => $coordinateY.$this->xAxis[$i-1],
                'user_id' => Auth::id()
            ]);
        }

        /**
         * Create Destroyers
         */
        $coordinatex = $this->xAxis[array_rand($this->xAxis)];
        for($i=((count($this->yAxis)/2)); $i<10; $i++){
            Ship::create([
                'ship_type' => 'Destroyers',
                'coordinates' => $this->yAxis[$i-1].$coordinatex,
                'user_id' => Auth::id()
            ]);
        }

        if(ShipServiceFacade::checkDuplicateRecord() > 0){
            $this->index();
        }
    }
}
