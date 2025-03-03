<?php

namespace App\Services\Contracts;

use App\DTOs\ClubDTO;
use App\Models\Club;
use Illuminate\Database\Eloquent\Collection;

interface IClubService
{
    public function getAll(): Collection;
    public function getById(int $id): Club;
    public function create(Club $newClub): Club;
    public function update(int $id, Club $updatedClub): ?Club;
    public function delete(int $id): bool;
}
