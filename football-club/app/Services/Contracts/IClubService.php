<?php

namespace App\Services\Contracts;

use App\DTOs\ClubDTO;
use Illuminate\Database\Eloquent\Collection;

interface IClubService
{
    public function getAll(): Collection;
    public function getById(int $id): ?ClubDTO;
    public function create(ClubDTO $newClub): ClubDTO;
    public function update(int $id, ClubDTO $updatedClub): ?ClubDTO;
    public function delete(int $id): bool;
}
