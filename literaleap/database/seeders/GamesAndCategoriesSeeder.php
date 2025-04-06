<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Category;

class GamesAndCategoriesSeeder extends Seeder
{
    public function run()
    {
        $category = Category::firstOrCreate([
            'name' => 'Action'
        ]);

        // Create a game.
        $game = Game::create([
            'title'       => 'Coin Clicker',
            'description' => 'This is a premium coin clicker game. Enjoy the premium experience!',
            'file'        => 'premium-assets/coin_clicker.js', // path relative to the public folder
            'thumbnail'   => 'images/game-thumbnail.jpg' // path relative to the public folder
        ]);

        // Attach the category to the game.
        $game->categories()->attach($category->id);

        // Insert Listen & Type Game
        $listenTypeGame = Game::create([
            'title'       => 'Listen & Type Game',
            'description' => 'Listen & Type is an engaging and educational game designed to improve English listening and spelling skills in young learners. This interactive game helps children develop phonetic awareness and word recognition by listening to spoken words and typing them correctly.',
            'file'        => 'js/listenTypeGame.js', // path relative to the public folder
            'thumbnail'   => 'images/listentype.jpg' // path relative to the public folder
        ]);
    }
}