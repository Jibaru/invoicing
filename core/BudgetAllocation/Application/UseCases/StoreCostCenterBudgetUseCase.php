<?php

namespace Core\BudgetAllocation\Application\UseCases;

use Core\BudgetAllocation\Domain\Entities\CostCenterBudget;
use Core\BudgetAllocation\Domain\Entities\Factories\CostCenterBudgetFactory;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Money;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetRepository;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\Period;
use Exception;

class StoreCostCenterBudgetUseCase
{
    private CostCenterBudgetFactory $costCenterBudgetFactory;
    private CostCenterBudgetRepository $costCenterBudgetRepository;

    public function __construct(
        CostCenterBudgetFactory $costCenterBudgetFactory,
        CostCenterBudgetRepository $costCenterBudgetRepository
    ) {
        $this->costCenterBudgetFactory = $costCenterBudgetFactory;
        $this->costCenterBudgetRepository = $costCenterBudgetRepository;
    }

    /**
     * @param Period $period
     * @param Money $amount
     * @param CostCenterID $costCenterID
     * @return CostCenterBudget
     * @throws Exception
     */
    public function __invoke(
        Period $period,
        Money $amount,
        CostCenterID $costCenterID
    ): CostCenterBudget {
        $costCenterBudget = $this->costCenterBudgetFactory->make($period, $amount, $costCenterID);

        $this->costCenterBudgetRepository->store($costCenterBudget);

        return $costCenterBudget;
    }
}
