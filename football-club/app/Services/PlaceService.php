<?php

namespace App\Services;

use App\DTOs\PlaceDTO;
use App\Models\Place;
use App\Repositories\Contracts\IPlaceRepository;
use App\Services\Contracts\IPlaceService;
use Illuminate\Database\Eloquent\Collection;

class PlaceService implements IPlaceService
{
    public function __construct(private IPlaceRepository $placeRepository) {}

    public function createPlace(PlaceDTO $placeDTO): Place
    {
        return $this->placeRepository->create($placeDTO);
    }

    public function getAllPlaces(): Collection
    {
        return $this->placeRepository->getAll();
    }

    public function getPlaceById(int $id): ?Place
    {
        return $this->placeRepository->getById($id);
    }

    public function updatePlace(int $id, PlaceDTO $placeDTO): ?Place
    {
        return $this->placeRepository->update($id, $placeDTO);
    }

    public function deletePlace(int $id): bool
    {
        return $this->placeRepository->delete($id);
    }
}
