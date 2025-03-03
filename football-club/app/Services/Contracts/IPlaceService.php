<?php

namespace App\Services\Contracts;

use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;

interface IPlaceService
{
    public function create(Place $newPlace): Place;
    public function getAll(): Collection;
    public function getById(int $id): ?Place;
    public function update(int $id, Place $updatedPlace): ?Place;
    public function delete(int $id): bool;
}
