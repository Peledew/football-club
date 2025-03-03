<?php

namespace App\Services\Contracts;

use App\DTOs\PlaceDTO;
use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;

interface IPlaceService
{
    public function createPlace(PlaceDTO $newPlace): PlaceDTO;
    public function getAllPlaces(): Collection;
    public function getPlaceById(int $id): ?PlaceDTO;
    public function updatePlace(int $id, PlaceDTO $updatedPlace): ?PlaceDTO;
    public function deletePlace(int $id): bool;
}
