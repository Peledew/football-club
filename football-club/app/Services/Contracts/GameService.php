<?php

namespace App\Services\Contracts;

use App\Models\Game;
use App\Repositories\Contracts\IGameRepository;
use Illuminate\Database\Eloquent\Collection;

class GameService implements IGameService
{
    private IGameRepository $_gameRepository;

    public function __construct(IGameRepository $gameRepository)
    {
        $this->_gameRepository = $gameRepository;
    }

    public function create(Game $newGame): Game
    {
        return $this->_gameRepository->create($newGame);
    }

    public function getAll(): Collection
    {
        return $this->_gameRepository->getAll();
    }

    public function getById(int $id): ?Game
    {
        return $this->_gameRepository->getById($id);
    }

    public function update(int $id, Game $updatedGame): ?Game
    {
        return $this->_gameRepository->update($id, $updatedGame);
    }

    public function delete(int $id): bool
    {
        return $this->_gameRepository->delete($id);
    }
}
