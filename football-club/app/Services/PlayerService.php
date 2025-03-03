<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\Contracts\IPlayerRepository;
use App\Services\Contracts\IPlayerService;
use Illuminate\Database\Eloquent\Collection;

class PlayerService implements IPlayerService
{
    private IPlayerRepository $_playerRepository;

    public function __construct(IPlayerRepository $playerRepository)
    {
        $this->_playerRepository = $playerRepository;
    }

    public function create(Player $newPlayer): Player
    {
        return $this->_playerRepository->create($newPlayer);
    }

    public function getAll(): Collection
    {
        return $this->_playerRepository->getAll();
    }

    public function getById(int $id): ?Player
    {
        return $this->_playerRepository->getById($id);
    }

    public function update(int $id, Player $updatedPlayer): ?Player
    {
        return $this->_playerRepository->update($id, $updatedPlayer);
    }

    public function delete(int $id): bool
    {
        return $this->_playerRepository->delete($id);
    }
}
