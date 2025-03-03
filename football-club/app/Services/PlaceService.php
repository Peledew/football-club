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

    public function create(PlaceDTO $newPlace): PlaceDTO
    {
        $place = new Place($newPlace->toArray());
        $this->_placeRepository->create($place);

        return PlaceDTO::fromModel($place);
    }

    public function getAll(): Collection
    {
        return $this->_placeRepository->getAll();
    }

    public function getById(int $id): ?PlaceDTO
    {
        $place =  $this->_placeRepository->getById($id);
        return new PlaceDTO($place->name, $place->ptt);
    }

    public function update(int $id, PlaceDTO $updatedPlace): ?PlaceDTO
    {
        $place = new Place($updatedPlace->toArray());
        $place = $this->_placeRepository->update($id, $place);
        return $place ? PlaceDTO::fromModel($place) : null;
    }

    public function delete(int $id): bool
    {
        return $this->_placeRepository->delete($id);
    }
}
