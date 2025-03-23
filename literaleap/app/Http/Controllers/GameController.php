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

    public function index(Request $request)
{
    $search = $request->input('search');
    $categoryId = $request->input('category');

    $gamesQuery = Game::with('categories');

    if ($search && !$categoryId) {
        $gamesQuery->where(function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    } elseif ($categoryId && !$search) {
        $gamesQuery->whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        });
    }

    $games = $gamesQuery->get();
    $categories = \App\Models\Category::all();

    return view('games', compact('games', 'categories', 'search', 'categoryId'));
}

    public function show(Game $game)
    {
        return view('game.show', compact('game'));
    }
}