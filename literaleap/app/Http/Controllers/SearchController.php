<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Game;
use App\Models\ShopItem;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::where('title', 'like', "%{$query}%")
            ->orWhere('body', 'like', "%{$query}%")
            ->paginate(5, ['*'], 'posts');

            $games = Game::where('title', 'like', "%{$query}%")
            ->orWhereHas('categories', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->with('categories') // loads related categories to show in results
            ->paginate(5, ['*'], 'games');

        $shopItems = ShopItem::where('name', 'like', "%{$query}%")
            ->paginate(5, ['*'], 'shopitems');

        return view('search.results', compact('query', 'posts', 'games', 'shopItems'));
    }
}