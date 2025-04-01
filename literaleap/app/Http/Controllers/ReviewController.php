<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Store a new review for a game.
    public function store(Request $request, Game $game)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string'
        ]);

        // Ensure the user doesn't already have a review for this game.
        $existingReview = $game->reviews()->where('user_id', Auth::id())->first();
        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this game.');
        }

        $game->reviews()->create([
            'user_id' => Auth::id(),
            'rating'  => $request->rating,
            'review'  => $request->review,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    // Show the edit form for a review.
    public function edit(Game $game, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        return view('reviews.edit', compact('game', 'review'));
    }

    // Update the user's review.
    public function update(Request $request, Game $game, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string'
        ]);

        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('games.show', $game->id)->with('success', 'Review updated successfully.');
    }

    // Delete a review.
    public function destroy(Game $game, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        $review->delete();
        return redirect()->route('games.show', $game->id)->with('success', 'Review deleted successfully.');
    }
}