<?php

namespace App\Repositories\Contracts;

use App\Models\Competition;
use Illuminate\Database\Eloquent\Collection;

interface ICompetitionRepository
{
    public function getAll(): Collection;

    public function getById(int $id): ?Competition;

    public function create(Competition $newCompetition): Competition;

    public function update(int $id, Competition $updatedCompetition): ?Competition;

    public function delete(int $id): bool;
}
