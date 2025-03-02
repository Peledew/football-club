<?php

namespace App\Repositories\Eloquent;

use App\DTOs\ClubDTO;
use App\Models\Club;
use App\Repositories\Contracts\IClubRepository;
use Illuminate\Database\Eloquent\Collection;

class ClubRepository implements IClubRepository
{
    public function getAll(): Collection
    {
        return Club::all();
    }

    public function getById(int $id): ?Club
    {
        return Club::find($id);
    }

    public function create(ClubDTO $dto): Club
    {
        return Club::create($dto->toArray());
    }

    public function update(int $id, ClubDTO $dto): ?Club
    {
        $club = Club::find($id);
        if (!$club) {
            return null;
        }

        $club->update($dto->toArray());
        return $club;
    }

    public function delete(int $id): bool
    {
        $club = Club::find($id);
        if (!$club) {
            return false;
        }

        return $club->delete();
    }
}
