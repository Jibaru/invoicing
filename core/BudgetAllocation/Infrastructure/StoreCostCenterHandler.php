<?php

namespace Core\BudgetAllocation\Infrastructure;

use Core\BudgetAllocation\Application\UseCases\StoreCostCenterUseCase;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterName;
use Core\BudgetAllocation\Infrastructure\Requests\StoreCostCenterRequest;
use Exception;
use Illuminate\Http\Response;

class StoreCostCenterHandler
{
    private StoreCostCenterUseCase $storeCostCenterUseCase;

    public function __construct(
        StoreCostCenterUseCase $storeCostCenterUseCase
    ) {
        $this->storeCostCenterUseCase = $storeCostCenterUseCase;
    }

    public function __invoke(StoreCostCenterRequest $request): Response
    {
        $name = new CostCenterName($request->input('name'));
        $code = new CostCenterCode($request->input('code'));

        try {
            $costCenter = $this->storeCostCenterUseCase->__invoke($name, $code);
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
