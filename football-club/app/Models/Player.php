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

    // Picture validation rules
    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'ssn' => 'required|unique:players|size:11',
            'date_of_birth' => 'required|date',
            'position' => 'required|in:CB,DMF,LB,CF',
            'place_id' => 'required|exists:places,id',
            'club_id' => 'required|exists:clubs,id',
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    // Helper function to store picture
    public function storePicture($file)
    {
        $path = $file->store('players_pictures', 'public');
        $this->picture = $path;
        $this->save();
    }
}
