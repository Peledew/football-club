<?php

namespace App\Repositories\Eloquent;

use App\DTOs\PlaceDTO;
use App\Models\Place;
use App\Repositories\Contracts\IPlaceRepository;
use Illuminate\Database\Eloquent\Collection;

class PlaceRepository implements IPlaceRepository
{
    public function create(Place $newPlace): Place
    {
        $newPlace->save();
        return $newPlace;
    }

    public function getAll(): Collection
    {
        return Place::all();
    }

    public function getById(int $id): ?Place
    {
        return Place::find($id);
    }

    public function update(int $id, Place $updatedPlace): ?Place
    {
        $place = Place::find($id);

        if ($place) {
            $place->update($updatedPlace->toArray());
        }

        return $place;
    }

    public function delete(int $id): bool
    {
        $place = Place::find($id);

        if ($place) {
            return $place->delete();
        }

        return false;
    }
}
