<?php

namespace App\Http\Controllers\CostCenters\CostCenter;

use Core\BudgetAllocation\Infrastructure\GetCostCenterHandler as InfrastructureGetCostCenterHandler;
use Illuminate\Http\Response;

class GetCostCenterHandler
{
    private InfrastructureGetCostCenterHandler $getCostCenterHandler;

    public function __construct(InfrastructureGetCostCenterHandler $getCostCenterHandler)
    {
        $this->getCostCenterHandler = $getCostCenterHandler;
    }

    public function __invoke(string $costCenterID): Response
    {
        return $this->getCostCenterHandler->__invoke($costCenterID);
    }
}
