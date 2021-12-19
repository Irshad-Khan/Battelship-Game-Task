<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UserSerivce
{
    /**
     * It is used to update user shoot. At the time of SUNK game
     * we use this count to show user total number of shots
     */
    public function updateShots()
    {
        Auth::user()->update(
            [
                'total_shots' => Auth::user()->total_shots+1
            ]
        );
    }

    /**
     * It is used to return total number of shots of user
     */
    public function getTotalShot()
    {
        return Auth::user()->total_shots;
    }

    public function initilizeTotalShot()
    {
        Auth::user()->update(
            [
                'total_shots' => 0
            ]
        );
    }
}
