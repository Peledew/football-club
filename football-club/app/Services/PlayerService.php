<?php

namespace App\Services;

use App\DTOs\PlayerDTO;
use App\Models\Player;
use App\Models\User;
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

    public function create(PlayerDTO $dto): Player
    {
        $user = new User([
            'username' => $dto->username,
            'email' => $dto->email,
            'name' => $dto->name,
            'password' => $dto->password,
        ]);

        $newPlayer = new Player([
            'last_name' => $dto->last_name,
            'ssn' => $dto->ssn,
            'date_of_birth' => $dto->date_of_birth,
            'position' => $dto->position,
            'place_id' => $dto->place_id,
            'club_id' => $dto->club_id,
            'picture' => $dto->picture,
        ]);

        return $this->_playerRepository->create($user, $newPlayer);
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
