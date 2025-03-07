<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;


class GameController extends Controller
{
    public function addCredit(Request $request)
    {
        $user = Auth::user();
        $user->credits += 1;
        $user->save();

        return response()->json([
            'message' => 'Credit added successfully!',
            'credits' => $user->credits
        ]);
    }

    public function index()
    {
        
        $games = Game::with('categories')->get();
        return view('games', compact('games'));
    }

    public function show(Game $game)
    {
        return view('game.show', compact('game'));
    }
}