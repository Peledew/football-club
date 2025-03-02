<?php

namespace App\Services\Contracts;

use App\DTOs\PlaceDTO;
use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;

interface IPlaceService
{
    public function createPlace(PlaceDTO $placeDTO): Place;
    public function getAllPlaces(): Collection;
    public function getPlaceById(int $id): ?Place;
    public function updatePlace(int $id, PlaceDTO $placeDTO): ?Place;
    public function deletePlace(int $id): bool;
}
