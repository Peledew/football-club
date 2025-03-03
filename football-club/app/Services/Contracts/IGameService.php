<?php

namespace App\Services\Contracts;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

interface IGameService
{
    public function create(Game $newGame): Game;

    public function getAll(): Collection;

    public function getById(int $id): ?Game;

    public function update(int $id, Game $updatedGame): ?Game;

    public function delete(int $id): bool;
}
