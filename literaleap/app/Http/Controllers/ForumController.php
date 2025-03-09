<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Reply;

class ForumController extends Controller
{
    public function index()
    {
        $posts = Post::with('replies.user')->latest()->get();
        // Return your existing forum view
        return view('forum', compact('posts'));
    }

    public function create()
    {
        return view('forum.create'); // Adjust the view as needed
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'title'   => $request->title,
            'body'    => $request->body,
        ]);

        return redirect()->route('forum.index')->with('success', 'Post created successfully.');
    }

    public function reply(Request $request, Post $post)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        Reply::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'body'    => $request->reply,
        ]);

        return redirect()->route('forum.index')->with('success', 'Reply posted successfully.');
    }

    public function like(Request $request, Post $post)
    {
        $action = $request->input('action');

        if ($action == 'like') {
            $post->likes_count += 1;
        } elseif ($action == 'unlike') {
            $post->likes_count = max($post->likes_count - 1, 0);
        } elseif ($action == 'switch_to_like') {
            $post->likes_count += 1;
            $post->dislikes_count = max($post->dislikes_count - 1, 0);
        }

        $post->save();

        return response()->json([
            'success' => true,
            'likes_count' => $post->likes_count,
            'dislikes_count' => $post->dislikes_count,
        ]);
    }

    public function dislike(Request $request, Post $post)
    {
        $action = $request->input('action');

        if ($action == 'dislike') {
            $post->dislikes_count += 1;
        } elseif ($action == 'undislike') {
            $post->dislikes_count = max($post->dislikes_count - 1, 0);
        } elseif ($action == 'switch_to_dislike') {
            $post->dislikes_count += 1;
            $post->likes_count = max($post->likes_count - 1, 0);
        }

        $post->save();

        return response()->json([
            'success' => true,
            'likes_count' => $post->likes_count,
            'dislikes_count' => $post->dislikes_count,
        ]);
    }
}