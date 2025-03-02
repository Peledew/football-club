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

    public function createPlace(PlaceDTO $placeDTO): Place
    {
        return $this->_placeRepository->create($placeDTO);
    }

    public function getAllPlaces(): Collection
    {
        return $this->_placeRepository->getAll();
    }

    public function getPlaceById(int $id): ?Place
    {
        return $this->_placeRepository->getById($id);
    }

    public function updatePlace(int $id, PlaceDTO $placeDTO): ?Place
    {
        return $this->_placeRepository->update($id, $placeDTO);
    }

    public function deletePlace(int $id): bool
    {
        return $this->_placeRepository->delete($id);
    }
}
