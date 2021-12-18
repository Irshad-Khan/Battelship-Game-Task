<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuessController extends Controller
{
    public function index()
    {
        Ship::truncate();
        Auth::user()->update(
            [
                'total_shots' => 0
            ]
        );
        $xAxis = ['1','2','3','4','5','6','7','8','9','10'];
        $yAxis = ['A','B','C','D','E','F','G','H','I','J'];

        $coordinateY = $yAxis[array_rand($yAxis)];

        for($i=1; $i< count($xAxis)/2; $i++){
            // $coordinate .= $coordinateY.$xAxis[$i-1].',';
            Ship::create([
                'ship_type' => 'Battleship',
                'coordinates' => $coordinateY.$xAxis[$i-1]
            ]);
        }



        $coordinatex = $xAxis[array_rand($xAxis)];
        for($i=((count($yAxis)/2)); $i<10; $i++){
            // $coordinateE .= $yAxis[$i-1].$coordinatex.',';
            Ship::create([
                'ship_type' => 'Destroyers',
                'coordinates' => $yAxis[$i-1].$coordinatex
            ]);
        }


        return view('battelship_board.index');
    }

    public function guess($xy)
    {
        $xy = ucfirst($xy);

        $ship = Ship::where('is_gussed',false)->count();
        Auth::user()->update(
            [
                'total_shots' => Auth::user()->total_shots+1
            ]
        );
        if($ship > 0){
            $ship = Ship::where('coordinates',$xy)->first();
            if($ship){
                $ship->is_gussed = true;
                $ship->save();
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

        return response()->json([
            'status' => 'sunk',
            'message' => "*** Sunk ***",
            'data' => $xy,
            'totalShot' => Auth::user()->total_shots
        ],200);

    }
}
