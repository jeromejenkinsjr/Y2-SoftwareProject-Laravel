<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
use HasFactory;

protected $fillable = ['name', 'team_code', 'created_by', 'image'];

// The teacher/admin who created the team.
public function creator()
{
return $this->belongsTo(User::class, 'created_by');
}

// Users belonging to the team.
public function users()
{
return $this->belongsToMany(User::class, 'team_user')
->withPivot('role', 'status', 'invited_by')
->withTimestamps();
}
}