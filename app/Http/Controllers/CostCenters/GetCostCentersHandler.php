<?php

namespace App\Http\Controllers\CostCenters;

use Core\BudgetAllocation\Infrastructure\GetCostCentersHandler as InfrastructureGetCostCentersHandler;
use Core\BudgetAllocation\Infrastructure\Requests\GetCostCentersRequest;
use Illuminate\Http\Response;

class GetCostCentersHandler
{
    private InfrastructureGetCostCentersHandler $getCostCentersHandler;

    public function __construct(InfrastructureGetCostCentersHandler $getCostCentersHandler)
    {
        $this->getCostCentersHandler = $getCostCentersHandler;
    }

    public function __invoke(GetCostCentersRequest $request): Response
    {
        return $this->getCostCentersHandler->__invoke($request);
    }
}
