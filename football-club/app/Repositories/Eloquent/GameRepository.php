<?php

namespace App\Repositories\Eloquent;

use App\Models\Game;
use App\Repositories\Contracts\IGameRepository;
use Illuminate\Database\Eloquent\Collection;

class GameRepository implements IGameRepository
{
    public function getAll(): Collection
    {
        return Game::all();
    }

    public function getById(int $id): ?Game
    {
        return Game::find($id);
    }

    public function create(Game $newGame): Game
    {
        $newGame->save();
        return $newGame;
    }

    public function update(int $id, Game $updatedGame): ?Game
    {
        $game = Game::find($id);
        if (!$game) {
            return null;
        }

        $game->update($updatedGame->toArray());
        return $game;
    }

    public function delete(int $id): bool
    {
        $game = Game::find($id);
        if (!$game) {
            return false;
        }

        return $game->delete();
    }
}
