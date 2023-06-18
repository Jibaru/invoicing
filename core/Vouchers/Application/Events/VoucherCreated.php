<?php

namespace Core\Vouchers\Application\Events;

use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\Vouchers\Domain\Entities\Voucher;

class VoucherCreated
{
    public readonly Voucher $voucher;
    public readonly CostCenterCode $costCenterCode;
    public readonly bool $hasBudget;

    public function __construct(
        Voucher $voucher,
        CostCenterCode $costCenterCode,
        bool $hasBudget
    ) {
        $this->voucher = $voucher;
        $this->costCenterCode = $costCenterCode;
        $this->hasBudget = $hasBudget;
    }
}
