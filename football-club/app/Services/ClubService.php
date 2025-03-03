<?php

namespace App\Services;

use App\DTOs\ClubDTO;
use App\Models\Club;
use App\Repositories\Contracts\IClubRepository;
use App\Services\Contracts\IClubService;
use Illuminate\Database\Eloquent\Collection;

class ClubService implements IClubService
{
    private IClubRepository $_clubRepository;

    public function __construct(IClubRepository $clubRepository)
    {
        $this->_clubRepository = $clubRepository;
    }

    public function create(ClubDTO $newClub): ClubDTO
    {
        $club = new Club($newClub->toArray());
        $this->_clubRepository->create($club);

        return ClubDTO::fromModel($club);
    }
    public function getAll(): Collection
    {
        return $this->_clubRepository->getAll();
    }

    public function getById(int $id): ?ClubDTO
    {
        $club = $this->_clubRepository->getById($id);
        return $club ? ClubDTO::fromModel($club) : null;
    }

    public function update(int $id, ClubDTO $updatedClub): ?ClubDTO
    {
        $newClubData = new Club($updatedClub->toArray());
        $club = $this->_clubRepository->update($id, $newClubData);
        return $club ? ClubDTO::fromModel($club) : null;
    }

    public function delete(int $id): bool
    {
        return $this->_clubRepository->delete($id);
    }
}
