<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'place_id'];

    // Relationship with Place (each club is located in a place)
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    // Relationship with Player (a club has many players)
    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
