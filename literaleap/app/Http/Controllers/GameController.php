<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}