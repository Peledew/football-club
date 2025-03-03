<?php

namespace App\Services\Contracts;

use App\DTOs\PlaceDTO;
use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;

interface IPlaceService
{
    public function create(PlaceDTO $newPlace): PlaceDTO;
    public function getAll(): Collection;
    public function getById(int $id): ?PlaceDTO;
    public function update(int $id, PlaceDTO $updatedPlace): ?PlaceDTO;
    public function delete(int $id): bool;
}
