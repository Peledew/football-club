<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends User
{
    protected $fillable = [
        'last_name',
        'ssn',
        'date_of_birth',
        'position',
        'place_id',
        'club_id',
        'picture'
    ];

    // Relationship with Place (each player has a place)
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    // Relationship with Club (each player belongs to a club)
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    // Relationship with Performance (a player can have multiple performances)
    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

}
