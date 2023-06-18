<?php

namespace Core\BudgetAllocation\Infrastructure;

use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Repositories\CostCenterRepository;
use Exception;
use Illuminate\Http\Response;

class GetCostCenterHandler
{
    private CostCenterRepository $costCenterRepository;

    public function __construct(CostCenterRepository $costCenterRepository)
    {
        $this->costCenterRepository = $costCenterRepository;
    }

    public function __invoke(string $costCenterID): Response
    {
        try {
            $costCenter = $this->costCenterRepository->getByCostCenterID(new CostCenterID($costCenterID));
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }

        return response([
            'data' => $costCenter->toArray(),
        ], 200);
    }
}
