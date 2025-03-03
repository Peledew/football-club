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

    public function create(CLub $newClub): Club
    {
        $newClub->save();
        return $newClub;
    }

    public function update(int $id, Club $updatedClub): ?Club
    {
        $club = Club::find($id);
        if (!$club) {
            return null;
        }

        $club->update($updatedClub->toArray());
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
