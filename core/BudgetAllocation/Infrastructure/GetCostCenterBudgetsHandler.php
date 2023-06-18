<?php

namespace Core\BudgetAllocation\Infrastructure;

use Core\BudgetAllocation\Application\UseCases\GetCostCenterBudgetsUseCase;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Infrastructure\Requests\GetCostCenterBudgetsRequest;
use Illuminate\Http\Response;

class GetCostCenterBudgetsHandler
{
    private GetCostCenterBudgetsUseCase $getCostCenterBudgetsUseCase;

    public function __construct(
        GetCostCenterBudgetsUseCase $getCostCenterBudgetsUseCase,
    ) {
        $this->getCostCenterBudgetsUseCase = $getCostCenterBudgetsUseCase;
    }

    public function __invoke(string $costCenterID, GetCostCenterBudgetsRequest $request): Response
    {
        $page = $request->input('page', 1);
        $paginate = $request->input('paginate', 15);

        [$items, $totalPages] = $this->getCostCenterBudgetsUseCase->__invoke(
            new CostCenterID($costCenterID),
            $page,
            $paginate
        );

        return response([
            'data' => collect($items)->map(fn ($costCenterBudget) => $costCenterBudget->toArray()),
            'page' => $page,
            'paginate' => $paginate,
            'total_pages' => $totalPages,
        ], 200);
    }
}
