<?php

namespace App\Services;

use App\Models\GameHistory;
use Illuminate\Support\Facades\Auth;

class GameHistoryService
{
    public function store()
    {
        GameHistory::create([
            'total_shots' => Auth::user()->total_shots,
            'user_id' => Auth::id()
        ]);
    }
}
