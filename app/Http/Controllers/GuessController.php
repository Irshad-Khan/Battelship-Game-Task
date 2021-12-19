<?php

namespace App\Http\Controllers;

use App\Contracts\GuessInterface;
use App\Services\GameHistoryFacades;
use App\Services\ShipServiceFacade;
use App\Services\UserFacades;

class GuessController extends Controller
{
    protected $guessInterface;
    public function __construct(GuessInterface $guessInterface)
    {
        $this->guessInterface = $guessInterface;
    }

    /**
     * Return to Board of the game
     */
    public function index()
    {
        $this->guessInterface->index();
        return view('battelship_board.index');
    }

    /**
     * It is used to update usr shots, also update status and guess user input
     */
    public function guess($xy)
    {
        UserFacades::updateShots();
        if(ShipServiceFacade::getCoordinateNotGuessed() > 0){
            if($ship = ShipServiceFacade::getShipByCoordinate($xy = ucfirst($xy))){
               ShipServiceFacade::updateShipCoordinateStatus($ship);
                return response()->json([
                    'status' => 'hit',
                    'message' => "*** Hit ***",
                    'data' => $xy
                ],200);
            }
            return response()->json([
                'status' => 'miss',
                'message' => "*** Miss ***",
                'data' => $xy
            ],200);
        }

        GameHistoryFacades::store();
        return response()->json([
            'status' => 'sunk',
            'message' => "*** Sunk ***",
            'data' => $xy,
            'totalShot' => UserFacades::getTotalShot(),
        ],200);

    }
}
