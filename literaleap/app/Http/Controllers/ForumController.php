<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Reply;
use App\Models\PostUserReaction;

class ForumController extends Controller
{
    public function index()
    {
        $posts = Post::with('replies.user')->latest()->get();
        return view('forum', compact('posts'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('forum_images', 'public');
        }
    
        Post::create([
            'user_id' => auth()->id(),
            'title'   => $request->title,
            'body'    => $request->body,
            'image'   => $imagePath,
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
    $user = auth()->user();
    $reaction = PostUserReaction::where('post_id', $post->id)
                    ->where('user_id', $user->id)
                    ->first();

    if ($reaction && $reaction->reaction === 'like') {
        // Remove like
        $reaction->delete();
        $post->decrement('likes_count');
    } elseif ($reaction && $reaction->reaction === 'dislike') {
        // Switch from dislike to like
        $reaction->update(['reaction' => 'like']);
        $post->increment('likes_count');
        $post->decrement('dislikes_count');
    } else {
        // Add new like
        PostUserReaction::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'reaction' => 'like',
        ]);
        $post->increment('likes_count');
    }

    return response()->json([
        'success' => true,
        'likes_count' => $post->likes_count, 
        'dislikes_count' => $post->dislikes_count,
    ]);
}

public function dislike(Request $request, Post $post)
{
    $user = auth()->user();
    $reaction = PostUserReaction::where('post_id', $post->id)
                    ->where('user_id', $user->id)
                    ->first();

    if ($reaction && $reaction->reaction === 'dislike') {
        // Remove dislike
        $reaction->delete();
        $post->decrement('dislikes_count');
    } elseif ($reaction && $reaction->reaction === 'like') {
        // Switch from like to dislike
        $reaction->update(['reaction' => 'dislike']);
        $post->increment('dislikes_count');
        $post->decrement('likes_count');
    } else {
        // Add new dislike
        PostUserReaction::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'reaction' => 'dislike',
        ]);
        $post->increment('dislikes_count');
    }

    return response()->json([
        'success' => true,
        'likes_count' => $post->likes_count,
        'dislikes_count' => $post->dislikes_count,
    ]);
}
    public function destroy(Post $post)
{
    if (auth()->user()->id !== $post->user_id && auth()->user()->role !== 'admin') {
        abort(403);
    }

    $post->delete();

    return redirect()->route('forum.index')->with('success', 'Post deleted successfully.');
}

}