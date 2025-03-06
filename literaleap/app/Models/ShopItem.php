<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'shop_item_user')
                    ->withPivot('purchased_at')
                    ->withTimestamps();
    }
}
