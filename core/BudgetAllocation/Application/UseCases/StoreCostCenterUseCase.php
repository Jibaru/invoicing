<?php

namespace Core\BudgetAllocation\Application\UseCases;

use Core\BudgetAllocation\Domain\Entities\CostCenter;
use Core\BudgetAllocation\Domain\Entities\Factories\CostCenterFactory;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterName;
use Core\BudgetAllocation\Domain\Repositories\CostCenterRepository;
use Exception;

class StoreCostCenterUseCase
{
    private CostCenterFactory $costCenterFactory;
    private CostCenterRepository $costCenterRepository;

    public function __construct(
        CostCenterFactory $costCenterFactory,
        CostCenterRepository $costCenterRepository,
    ) {
        $this->costCenterFactory = $costCenterFactory;
        $this->costCenterRepository = $costCenterRepository;
    }

    /**
     * @param CostCenterName $name
     * @param CostCenterCode $code
     * @return CostCenter
     * @throws Exception
     */
    public function __invoke(
        CostCenterName $name,
        CostCenterCode $code,
    ): CostCenter {
        $costCenter = $this->costCenterFactory->make($name, $code);

        $this->costCenterRepository->store($costCenter);

        return $costCenter;
    }
}
