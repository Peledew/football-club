<?php

namespace App\Repositories\Contracts;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface IPlayerRepository
{
    public function create(User $user, Player $newPlayer): Player;
    public function getAll(): Collection;
    public function getById(int $id): ?Player;
    public function update(int $id, Player $updatedPlayer): ?Player;
    public function delete(int $id): bool;
}
