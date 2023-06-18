<?php

namespace Core\BudgetAllocation\Infrastructure;

use Core\BudgetAllocation\Application\UseCases\GetCostCentersUseCase;
use Core\BudgetAllocation\Infrastructure\Requests\GetCostCentersRequest;
use Illuminate\Http\Response;

class GetCostCentersHandler
{
    private GetCostCentersUseCase $getCostCentersUseCase;

    public function __construct(GetCostCentersUseCase $getCostCentersUseCase)
    {
        $this->getCostCentersUseCase = $getCostCentersUseCase;
    }

    public function __invoke(GetCostCentersRequest $request): Response
    {
        $page = $request->input('page', 1);
        $paginate = $request->input('paginate', 15);

        [$items, $totalPages] = $this->getCostCentersUseCase->__invoke($page, $paginate);

        return response([
            'data' => collect($items)->map(fn ($costCenter) => $costCenter->toArray()),
            'page' => $page,
            'paginate' => $paginate,
            'total_pages' => $totalPages,
        ], 200);
    }
}
