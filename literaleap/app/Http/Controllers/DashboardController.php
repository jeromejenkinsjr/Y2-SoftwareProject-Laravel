<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the newest game
        $newestGame = Game::orderBy('created_at', 'desc')->first();

        // Fetch two other games that are not the newest
        $otherGames = Game::where('id', '!=', $newestGame->id)
                        ->orderBy('created_at', 'desc')
                        ->take(2)
                        ->get();

        return view('dashboard', compact('newestGame', 'otherGames'));
    }
}