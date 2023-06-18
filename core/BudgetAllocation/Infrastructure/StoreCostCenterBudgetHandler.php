<?php

namespace Core\BudgetAllocation\Infrastructure;

use Core\BudgetAllocation\Application\UseCases\StoreCostCenterBudgetUseCase;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Currency;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Money;
use Core\BudgetAllocation\Infrastructure\Requests\StoreCostCenterBudgetRequest;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\Period;
use Illuminate\Http\Response;

class StoreCostCenterBudgetHandler
{
    private StoreCostCenterBudgetUseCase $storeCostCenterBudgetUseCase;

    public function __construct(StoreCostCenterBudgetUseCase $storeCostCenterBudgetUseCase)
    {
        $this->storeCostCenterBudgetUseCase = $storeCostCenterBudgetUseCase;
    }

    public function __invoke(string $costCenterID, StoreCostCenterBudgetRequest $request): Response
    {
        $period = new Period(
            $request->input('month'),
            $request->input('year'),
        );

        $amount = new Money(
            new Currency($request->input('amount.currency')),
            $request->input('amount.value'),
        );

        try {
            $costCenterBudget = $this->storeCostCenterBudgetUseCase->__invoke(
                $period,
                $amount,
                new CostCenterID($costCenterID)
            );
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }

        return response([
            'data' => $costCenterBudget->toArray(),
        ], 201);
    }
}
