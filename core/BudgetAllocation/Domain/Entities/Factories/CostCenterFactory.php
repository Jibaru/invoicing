<?php

namespace Core\BudgetAllocation\Domain\Entities\Factories;

use Carbon\Carbon;
use Core\BudgetAllocation\Domain\Entities\CostCenter;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterName;
use Core\BudgetAllocation\Domain\Repositories\CostCenterRepository;
use Exception;

class CostCenterFactory
{
    private CostCenterRepository $costCenterRepository;

    public function __construct(CostCenterRepository $costCenterRepository)
    {
        $this->costCenterRepository = $costCenterRepository;
    }

    /**
     * @param CostCenterName $name
     * @param CostCenterCode $code
     * @return CostCenter
     * @throws Exception
     */
    public function make(CostCenterName $name, CostCenterCode $code): CostCenter
    {
        if ($this->costCenterRepository->existsByCode($code)) {
            throw new Exception('the cost center code already exists');
        }

        return new CostCenter(
            CostCenterID::empty(),
            $code,
            $name,
            Carbon::now(),
            Carbon::now(),
        );
    }
}
