<?php

namespace App\Services;

use App\Models\Ship;
use Illuminate\Support\Facades\Auth;

class ShipService
{
    /**
     * Return Ship Coordinate Count thoes are not gueesed by user. On this user can continue game
     * If the count is zero its mean all ships are hit and game status is sunk.
     */
    public function getCoordinateNotGuessed()
    {
        return Ship::where('is_gussed',false)->where('user_id',Auth::id())->count();
    }

    /**
     * It is used to check user guess coordinate in to computer coordinate
     * if coordinate exist its mean user guess the coordinate and return
     * current coordinate
     */
    public function getShipByCoordinate($coordinate)
    {
        return Ship::where('coordinates',$coordinate)->where('user_id',Auth::id())->first();
    }

    /**
     * It is used to update guessed coordinate status to true. Its mean
     * user guess the coordinate
     */
    public function updateShipCoordinateStatus($ship)
    {
        $ship->is_gussed = true;
        $ship->save();
    }

    /**
     * We turncate ship and coordinate each time when user start new game.
     * Because we have to need store rendom coordinate for ships
     */
    public function truncateShip()
    {
        Ship::where('user_id', Auth::id())->delete();
    }

    /**
     * It check for overlapping for ships
     */
    public function checkDuplicateRecord()
    {
        $ships = Ship::where('user_id',Auth::id())->get();
        return $ships->diff($ships->unique('coordinates'))->count();
    }
}
