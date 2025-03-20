<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'credits',
        'xp',
        'level',
        'role',
        'premium',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function shopItems()
{
    return $this->belongsToMany(ShopItem::class, 'shop_item_user')
                ->withPivot('purchased_at')
                ->withTimestamps();
}

public function checkLevelUp()
    {
        $levelThresholds = [0, 10, 25, 50, 100, 200, 500, 1000]; 

        for ($i = count($levelThresholds) - 1; $i >= 0; $i--) {
            if ($this->xp >= $levelThresholds[$i]) {
                if ($this->level < $i + 1) {
                    $this->level = $i + 1;
                    $this->save();
                }
                break;
            }
        }
    }

}