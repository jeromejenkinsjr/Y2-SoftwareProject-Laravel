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
    $sortBy = $request->input('sort_by');

    $gamesQuery = Game::with('categories')->withAvg('reviews', 'rating');

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

    if ($sortBy === 'average') {
        $gamesQuery->orderBy('reviews_avg_rating', 'desc');
    } elseif ($sortBy === 'newest') {
        $gamesQuery->orderBy('created_at', 'desc');
    }

    $games = $gamesQuery->get();
    $categories = \App\Models\Category::all();

    return view('games', compact('games', 'categories', 'search', 'categoryId'));
}

    public function show(Game $game)
    {
        if ($game->title === 'Coin Clicker' && (!Auth::check() || !Auth::user()->premium)) {
            return redirect()->route('games.index')->with('error', 'You must be a premium member to access this game. <a href="' . route('subscribe') . '">Subscribe here</a>.');
        }
    
        return view('game.show', compact('game'));
    }

    public function addXp(Request $request)
{
    $user = Auth::user();
    $user->xp += 100;
    $user->save();

    return response()->json([
        'message' => 'XP added successfully!',
        'xp' => $user->xp
    ]);
}

}