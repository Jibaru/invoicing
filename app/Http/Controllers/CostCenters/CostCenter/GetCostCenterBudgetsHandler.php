<?php

namespace App\Http\Controllers\CostCenters\CostCenter;

use Core\BudgetAllocation\Infrastructure\GetCostCenterBudgetsHandler as InfrastructureGetCostCenterBudgetsHandler;
use Core\BudgetAllocation\Infrastructure\Requests\GetCostCenterBudgetsRequest;
use Illuminate\Http\Response;

class GetCostCenterBudgetsHandler
{
    private InfrastructureGetCostCenterBudgetsHandler $getCostCenterBudgetsHandler;

    public function __construct(
        InfrastructureGetCostCenterBudgetsHandler $getCostCenterBudgetsHandler
    ) {
        $this->getCostCenterBudgetsHandler = $getCostCenterBudgetsHandler;
    }

    public function __invoke(string $costCenterID, GetCostCenterBudgetsRequest $request): Response
    {
        return $this->getCostCenterBudgetsHandler->__invoke($costCenterID, $request);
    }
}
