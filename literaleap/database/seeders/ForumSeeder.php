<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Reply;

class ForumSeeder extends Seeder
{
    public function run()
    {
        // Use an existing user or create one if none exists
        $user = User::first() ?? User::factory()->create();

        // Create 3 sample posts
        for ($i = 1; $i <= 3; $i++) {
            $post = Post::create([
                'user_id' => $user->id,
                'title' => "Sample Post $i",
                'body'  => "This is the body of sample post $i.",
                'likes_count' => rand(0, 10),
                'dislikes_count' => rand(0, 5),
            ]);

            // Create 2 replies for each post
            for ($j = 1; $j <= 2; $j++) {
                Reply::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'body'    => "This is reply $j for sample post $i.",
                ]);
            }
        }
    }
}