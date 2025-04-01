<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
use HasFactory;

protected $fillable = [
'user_id', 'title', 'body', 'image', 'likes_count', 'dislikes_count'
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function replies()
{
    return $this->hasMany(Reply::class);
}

public function reactions()
{
    return $this->hasMany(PostUserReaction::class);
}

}