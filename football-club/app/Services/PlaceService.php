<?php

namespace App\Services;

use App\DTOs\PlaceDTO;
use App\Models\Place;
use App\Repositories\Contracts\IPlaceRepository;
use App\Services\Contracts\IPlaceService;
use Illuminate\Database\Eloquent\Collection;

class PlaceService implements IPlaceService
{
    private IPlaceRepository $_placeRepository;
    public function __construct(IPlaceRepository $placeRepository)
    {
        $this->_placeRepository = $placeRepository;
    }

    public function create(Place $newPlace): Place
    {
        return $this->_placeRepository->create($newPlace);
    }

    public function getAll(): Collection
    {
        return $this->_placeRepository->getAll();
    }

    public function getById(int $id): ?Place
    {
        return $this->_placeRepository->getById($id);
    }

    public function update(int $id, Place $updatedPlace): ?Place
    {
        return $this->_placeRepository->update($id, $updatedPlace);
    }

    public function delete(int $id): bool
    {
        return $this->_placeRepository->delete($id);
    }
}
