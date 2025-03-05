<?php

namespace App\Services\Contracts;

use App\DTOs\PlayerDTO;
use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface IPlayerService
{
    public function create(PlayerDTO $dto): Player;
    public function getAll(): Collection;
    public function getById(int $id): ?Player;
    public function update(int $id, Player $updatedPlayer): ?Player;
    public function delete(int $id): bool;
}
