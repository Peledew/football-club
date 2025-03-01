<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['ptt', 'name'];

    // Relationship with Player (a place can have multiple players)
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    // Relationship with Club (a place can have multiple clubs)
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }
}
