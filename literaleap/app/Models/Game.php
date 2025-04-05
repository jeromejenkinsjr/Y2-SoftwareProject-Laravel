<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;
    
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