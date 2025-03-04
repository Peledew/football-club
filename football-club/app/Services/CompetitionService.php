<?php

namespace App\Services;

use App\Models\Competition;
use App\Repositories\Contracts\ICompetitionRepository;
use App\Services\Contracts\ICompetitionService;
use Illuminate\Database\Eloquent\Collection;

class CompetitionService implements ICompetitionService
{
    private ICompetitionRepository $_competitionRepository;

    public function __construct(ICompetitionRepository $competitionRepository)
    {
        $this->_competitionRepository = $competitionRepository;
    }

    public function create(Competition $newCompetition): Competition
    {
        return $this->_competitionRepository->create($newCompetition);
    }

    public function getAll(): Collection
    {
        return $this->_competitionRepository->getAll();
    }

    public function getById(int $id): ?Competition
    {
        return $this->_competitionRepository->getById($id);
    }

    public function update(int $id, Competition $updatedCompetition): ?Competition
    {
        return $this->_competitionRepository->update($id, $updatedCompetition);
    }

    public function delete(int $id): bool
    {
        return $this->_competitionRepository->delete($id);
    }
}
