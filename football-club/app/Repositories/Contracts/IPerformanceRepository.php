<?php

namespace App\Repositories\Contracts;

use App\Models\Performance;
use Illuminate\Database\Eloquent\Collection;

interface IPerformanceRepository
{
    public function create(Performance $newPerformance): Performance;

    public function getAll(): Collection;

    public function getById(int $id): ?Performance;

    public function update(int $id, Performance $updatedPerformance): ?Performance;

    public function delete(int $id): bool;
}
