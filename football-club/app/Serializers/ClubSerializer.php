<?php

namespace App\Serializers;

class ClubSerializer
{
    public function serializeCollection($clubs)
    {
        return $clubs->map(function($club) {
            return $this->serialize($club);
        });
    }

    public function serialize($club)
    {
        return [
            'id' => $club->id,
            'name' => $club->name,
            'place' => $club->place->name,
        ];
    }
}
