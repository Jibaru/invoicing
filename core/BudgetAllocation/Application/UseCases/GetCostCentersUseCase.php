<?php

namespace Core\BudgetAllocation\Application\UseCases;

use Core\BudgetAllocation\Domain\Repositories\CostCenterRepository;

class GetCostCentersUseCase
{
    private CostCenterRepository $costCenterRepository;

    public function __construct(CostCenterRepository $costCenterRepository)
    {
        $this->costCenterRepository = $costCenterRepository;
    }

    public function __invoke(int $page, int $paginate): array
    {
        $costCenters = $this->costCenterRepository->getCostCenters($page, $paginate);
        $totalPages = $this->costCenterRepository->getTotalPages($paginate);

        return [
            $costCenters,
            $totalPages
        ];
    }
}
