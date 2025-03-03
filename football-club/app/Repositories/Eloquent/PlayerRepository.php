<?php

namespace App\Repositories\Eloquent;

use App\Models\Player;
use App\Repositories\Contracts\IPlayerRepository;
use Illuminate\Database\Eloquent\Collection;

class PlayerRepository implements IPlayerRepository
{

    public function create(Player $newPlayer): Player
    {
        $newPlayer->save();
        return $newPlayer;
    }

    public function getAll(): Collection
    {
        return Player::all();
    }

    public function getById(int $id): ?Player
    {
        return Player::find($id);
    }

    public function update(int $id, Player $updatedPlayer): ?Player
    {
        $player = Player::find($id);

        if ($player) {
            $player->update($updatedPlayer->toArray());
        }

        return $player;
    }

    public function delete(int $id): bool
    {
        $player = Player::find($id);

        if ($player) {
            return $player->delete();
        }

        return false;
    }
}
