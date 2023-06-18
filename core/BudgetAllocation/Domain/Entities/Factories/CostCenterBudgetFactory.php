<?php

namespace Core\BudgetAllocation\Domain\Entities\Factories;

use Carbon\Carbon;
use Core\BudgetAllocation\Domain\Entities\CostCenterBudget;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Money;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetRepository;
use Core\BudgetAllocation\Domain\Repositories\CostCenterRepository;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\Period;
use Exception;

class CostCenterBudgetFactory
{
    private CostCenterBudgetRepository $costCenterBudgetRepository;
    private CostCenterRepository $costCenterRepository;

    public function __construct(
        CostCenterRepository $costCenterRepository,
        CostCenterBudgetRepository $costCenterBudgetRepository,
    ) {
        $this->costCenterRepository = $costCenterRepository;
        $this->costCenterBudgetRepository = $costCenterBudgetRepository;
    }

    /**
     * @param Period $period
     * @param Money $amount
     * @param CostCenterID $costCenterID
     * @return CostCenterBudget
     * @throws Exception
     */
    public function make(Period $period, Money $amount, CostCenterID $costCenterID): CostCenterBudget
    {
        if (!$this->costCenterRepository->existsByCostCenterID($costCenterID)) {
            throw new Exception('cost center id does not exists');
        }

        if ($this->costCenterBudgetRepository->existsByPeriodAndCostCenterID($period, $costCenterID)) {
            throw new Exception('cost center budget for this period and cost center already exists');
        }

        return new CostCenterBudget(
            CostCenterBudgetID::empty(),
            $period,
            $amount,
            $costCenterID,
            Carbon::now(),
            Carbon::now(),
        );
    }
}
