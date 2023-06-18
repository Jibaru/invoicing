<?php

namespace Core\BudgetAllocation\Domain\Repositories;

use Core\BudgetAllocation\Domain\Entities\CostCenter;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Exception;

interface CostCenterRepository
{
    public function store(CostCenter $costCenter): void;
    public function getCostCenters(int $page, ?int $perPage = null): array;
    public function getTotalPages(int $perPage): int;
    public function existsByCode(CostCenterCode $costCenterCode): bool;
    public function existsByCostCenterID(CostCenterID $costCenterID): bool;

    /**
     * @param CostCenterID $costCenterID
     * @return CostCenter
     * @throws Exception
     */
    public function getByCostCenterID(CostCenterID $costCenterID): CostCenter;

    /**
     * @param CostCenterCode $costCenterCode
     * @return CostCenter
     * @throws Exception
     */
    public function getByCostCenterCode(CostCenterCode $costCenterCode): CostCenter;
}
