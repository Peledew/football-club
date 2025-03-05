<?php

namespace App\Repositories\Eloquent;

use App\Models\Performance;
use App\Repositories\Contracts\IPerformanceRepository;
use Illuminate\Database\Eloquent\Collection;

class PerformanceRepository implements IPerformanceRepository
{
    public function getAll(): Collection
    {
        return Performance::all();
    }

    public function getById(int $id): ?Performance
    {
        return Performance::find($id);
    }

    public function create(Performance $newPerformance): Performance
    {
        $newPerformance->save();
        return $newPerformance;
    }

    public function update(int $id, Performance $updatedPerformance): ?Performance
    {
        $performance = Performance::find($id);
        if (!$performance) {
            return null;
        }

        $performance->update($updatedPerformance->toArray());
        return $performance;
    }

    public function delete(int $id): bool
    {
        $performance = Performance::find($id);
        if (!$performance) {
            return false;
        }

        return $performance->delete();
    }
}
