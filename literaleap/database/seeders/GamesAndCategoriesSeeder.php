<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Category;

class GamesAndCategoriesSeeder extends Seeder
{
    public function run()
    {
        // Create or get the category.
        $category = Category::firstOrCreate([
            'name' => 'Action'
        ]);

        // Create a game.
        $game = Game::create([
            'title'       => 'My First Game',
            'description' => 'This is a sample game. Enjoy the action!',
            'file'        => 'js/game.js', // path relative to the public folder
            'thumbnail'   => 'images/game-thumbnail.jpg' // path relative to the public folder
        ]);

        // Attach the category to the game.
        $game->categories()->attach($category->id);
    }
}