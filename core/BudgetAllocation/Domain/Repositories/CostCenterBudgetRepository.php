<?php

namespace Core\BudgetAllocation\Domain\Repositories;

use Core\BudgetAllocation\Domain\Entities\CostCenterBudget;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Money;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\Period;
use Exception;

interface CostCenterBudgetRepository
{
    public function store(CostCenterBudget $costCenterBudget): void;
    public function existsByPeriodAndCostCenterID(Period $period, CostCenterID $costCenterID): bool;

    /**
     * @param Period $period
     * @param CostCenterCode $costCenterCode
     * @return CostCenterBudget
     * @throws Exception
     */
    public function getByPeriodAndCostCenterCode(Period $period, CostCenterCode $costCenterCode): CostCenterBudget;
    public function getCostCenterBudgets(CostCenterID $costCenterID, int $page, ?int $perPage = null): array;
    public function getTotalPages(CostCenterID $costCenterID, int $perPage): int;
    public function updateAmount(Money $newAmount, CostCenterBudgetID $costCenterBudgetID): void;
}
