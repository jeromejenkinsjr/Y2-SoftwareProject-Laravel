<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopItem;

class ShopController extends Controller
{
    public function index()
    {
        // Get all shop items (icons will have type 'icon')
        $shopItems = ShopItem::all();
        return view('shop', compact('shopItems'));
    }

    public function buyItem(Request $request, $shopItemId)
    {
        $user = Auth::user();
        $item = ShopItem::findOrFail($shopItemId);

        // Check if the user already owns this item
        if ($user->shopItems()->where('shop_item_id', $shopItemId)->exists()) {
            return redirect()->back()->with('error', 'You already own this item.');
        }

        // Check if the user has enough credits
        if ($user->credits < $item->price) {
            return redirect()->back()->with('error', 'Not enough credits.');
        }

        // Deduct credits
        $user->credits -= $item->price;
        $user->save();

        // Record the purchase (attach item to user)
        $user->shopItems()->attach($shopItemId, ['purchased_at' => now()]);

        return redirect()->back()->with('success', 'Item purchased successfully!');
    }

    public function show($id)
    {
        $item = ShopItem::findOrFail($id);
        return view('shop.show', compact('item'));
    }
}