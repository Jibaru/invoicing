<?php

namespace Core\BudgetAllocation\Domain\Entities\Factories;

use Carbon\Carbon;
use Core\BudgetAllocation\Domain\Entities\CostCenterBudgetExpense;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseType;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Money;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetExpenseRepository;
use Core\Vouchers\Domain\Entities\ValueObjects\VoucherID;

class CostCenterBudgetExpenseFactory
{
    private CostCenterBudgetExpenseRepository $costCenterBudgetExpenseRepository;

    public function __construct(CostCenterBudgetExpenseRepository $costCenterBudgetExpenseRepository)
    {
        $this->costCenterBudgetExpenseRepository = $costCenterBudgetExpenseRepository;
    }

    public function make(
        bool $isService,
        Money $amount,
        CostCenterBudgetID $costCenterBudgetID,
        VoucherID $voucherID,
    ): CostCenterBudgetExpense
    {
        $type = $isService
            ? CostCenterBudgetExpenseType::service()
            : CostCenterBudgetExpenseType::good();
        $code = $this->costCenterBudgetExpenseRepository->nextCode($type);

        return new CostCenterBudgetExpense(
            CostCenterBudgetExpenseID::empty(),
            $type,
            $code,
            $amount,
            $costCenterBudgetID,
            $voucherID,
            Carbon::now(),
            Carbon::now(),
        );
    }
}
