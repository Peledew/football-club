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

    public function getAll(): Collection
    {
        return $this->_clubRepository->getAll();
    }

    public function getById(int $id): ?Club
    {
        return $this->_clubRepository->getById($id);
    }

    public function create(ClubDTO $dto): Club
    {
        return $this->_clubRepository->create($dto);
    }

    public function update(int $id, ClubDTO $dto): ?Club
    {
        return $this->_clubRepository->update($id, $dto);
    }

    public function delete(int $id): bool
    {
        return $this->_clubRepository->delete($id);
    }
}
