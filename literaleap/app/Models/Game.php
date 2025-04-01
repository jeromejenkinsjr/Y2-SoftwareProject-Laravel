<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['title', 'description', 'file', 'thumbnail'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_game');
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}

}