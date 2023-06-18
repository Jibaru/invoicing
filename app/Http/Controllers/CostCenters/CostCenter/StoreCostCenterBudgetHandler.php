<?php

namespace App\Http\Controllers\CostCenters\CostCenter;

use Core\BudgetAllocation\Infrastructure\Requests\StoreCostCenterBudgetRequest;
use Core\BudgetAllocation\Infrastructure\StoreCostCenterBudgetHandler as InfrastructureStoreCostCenterBudgetHandler;
use Illuminate\Http\Response;

class StoreCostCenterBudgetHandler
{
    private InfrastructureStoreCostCenterBudgetHandler $storeCostCenterBudgetHandler;

    public function __construct(InfrastructureStoreCostCenterBudgetHandler $storeCostCenterBudgetHandler)
    {
        $this->storeCostCenterBudgetHandler = $storeCostCenterBudgetHandler;
    }

    public function __invoke(string $costCenterID, StoreCostCenterBudgetRequest $request): Response
    {
        return $this->storeCostCenterBudgetHandler->__invoke($costCenterID, $request);
    }
}
