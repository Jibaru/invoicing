<?php

namespace App\Http\Controllers\CostCenters;

use Core\BudgetAllocation\Infrastructure\Requests\StoreCostCenterRequest;
use Core\BudgetAllocation\Infrastructure\StoreCostCenterHandler as InfrastructureStoreCostCenterHandler;
use Illuminate\Http\Response;

class StoreCostCenterHandler
{
    private InfrastructureStoreCostCenterHandler $storeCostCenterHandler;

    public function __construct(
        InfrastructureStoreCostCenterHandler $storeCostCenterHandler
    ) {
        $this->storeCostCenterHandler = $storeCostCenterHandler;
    }

    public function __invoke(StoreCostCenterRequest $request): Response
    {
        return $this->storeCostCenterHandler->__invoke($request);
    }
}
