<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function homeClub()
    {
        return $this->belongsTo(Club::class, 'home_club_id');
    }

    public function guestClub()
    {
        return $this->belongsTo(Club::class, 'guest_club_id');
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }
}
