<?php

namespace Core\BudgetAllocation\Application\UseCases;

use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetRepository;

class GetCostCenterBudgetsUseCase
{
    private CostCenterBudgetRepository $costCenterBudgetRepository;

    public function __construct(CostCenterBudgetRepository $costCenterBudgetRepository)
    {
        $this->costCenterBudgetRepository = $costCenterBudgetRepository;
    }

    public function __invoke(CostCenterID $costCenterID, int $page, int $paginate): array
    {
        $costCenterBudgets = $this->costCenterBudgetRepository->getCostCenterBudgets($costCenterID, $page, $paginate);
        $totalPages = $this->costCenterBudgetRepository->getTotalPages($costCenterID, $paginate);

        return [
            $costCenterBudgets,
            $totalPages
        ];
    }
}
