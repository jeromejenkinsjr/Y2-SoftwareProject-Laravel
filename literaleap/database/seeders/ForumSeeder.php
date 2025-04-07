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
        // Use an existing user or create one
        $user = User::first() ?? User::factory()->create();

        $posts = [
            [
                'title' => 'Tips for Learning Laravel?',
                'body' => 'Hey everyone, I just started learning Laravel. Do you have any recommended resources or tips to speed up the process?'
            ],
            [
                'title' => 'What’s Your Favourite Dev Tool?',
                'body' => 'I’m curious what development tools or extensions you all can’t live without. VSCode extensions, CLI tools, anything goes!'
            ],
            [
                'title' => 'How to Deploy on Shared Hosting?',
                'body' => 'I’ve been trying to deploy my Laravel project to a shared hosting environment and running into issues. Anyone got a step-by-step?'
            ],
            [
                'title' => 'Sample Post 4',
                'body' => 'This is the body of sample post 4.'
            ],
            [
                'title' => 'Sample Post 5',
                'body' => 'This is the body of sample post 5.'
            ],
            [
                'title' => 'Sample Post 6',
                'body' => 'This is the body of sample post 6.'
            ],
        ];

        foreach ($posts as $index => $postData) {
            $post = Post::create([
                'user_id' => $user->id,
                'title' => $postData['title'],
                'body'  => $postData['body'],
                'likes_count' => rand(0, 15),
                'dislikes_count' => rand(0, 5),
            ]);

            // 2 Replies for each post
            for ($j = 1; $j <= 2; $j++) {
                Reply::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'body'    => "This is reply $j for \"{$post->title}\".",
                ]);
            }
        }
    }
}