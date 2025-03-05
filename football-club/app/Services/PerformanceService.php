<?php

namespace App\Services;

use App\Repositories\Contracts\IPerformanceRepository;
use App\Services\Contracts\IPerformanceService;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Performance;

class PerformanceService implements IPerformanceService
{
    private IPerformanceRepository $_performanceRepository;

    public function __construct(IPerformanceRepository $performanceRepository)
    {
        $this->_performanceRepository = $performanceRepository;
    }

    public function create(Performance $newPerformance): Performance
    {
        return $this->_performanceRepository->create($newPerformance);
    }

    public function getAll(): Collection
    {
        return $this->_performanceRepository->getAll();
    }

    public function getById(int $id): ?Performance
    {
        return $this->_performanceRepository->getById($id);
    }

    public function update(int $id, Performance $updatedPerformance): ?Performance
    {
        return $this->_performanceRepository->update($id, $updatedPerformance);
    }

    public function delete(int $id): bool
    {
        return $this->_performanceRepository->delete($id);
    }
}
