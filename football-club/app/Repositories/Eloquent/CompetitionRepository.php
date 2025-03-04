<?php

namespace App\Repositories\Eloquent;

use App\Models\Competition;
use App\Repositories\Contracts\ICompetitionRepository;
use Illuminate\Database\Eloquent\Collection;

class CompetitionRepository implements ICompetitionRepository
{
    public function getAll(): Collection
    {
        return Competition::all();
    }

    public function getById(int $id): ?Competition
    {
        return Competition::find($id);
    }

    public function create(Competition $newCompetition): Competition
    {
        $newCompetition->save();
        return $newCompetition;
    }

    public function update(int $id, Competition $updatedCompetition): ?Competition
    {
        $competition = Competition::find($id);
        if (!$competition) {
            return null;
        }

        $competition->update($updatedCompetition->toArray());
        return $competition;
    }

    public function delete(int $id): bool
    {
        $competition = Competition::find($id);
        if (!$competition) {
            return false;
        }

        return $competition->delete();
    }
}
