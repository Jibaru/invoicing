<?php

namespace Core\BudgetAllocation\Domain\Entities;

use Carbon\Carbon;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseType;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Money;
use Core\Vouchers\Domain\Entities\ValueObjects\VoucherID;

class CostCenterBudgetExpense
{
    private CostCenterBudgetExpenseID $id;
    private CostCenterBudgetExpenseType $type;
    private CostCenterBudgetExpenseCode $code;
    private Money $amount;
    private CostCenterBudgetID $costCenterBudgetID;
    private VoucherID $voucherID;
    private Carbon $createdAt;
    private Carbon $updatedAt;

    public function __construct(
        CostCenterBudgetExpenseID $id,
        CostCenterBudgetExpenseType $type,
        CostCenterBudgetExpenseCode $code,
        Money $amount,
        CostCenterBudgetID $costCenterBudgetID,
        VoucherID $voucherID,
        Carbon $createdAt,
        Carbon $updatedAt
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->code = $code;
        $this->amount = $amount;
        $this->costCenterBudgetID = $costCenterBudgetID;
        $this->voucherID = $voucherID;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value,
            'type' => $this->type->value,
            'code' => $this->code->value,
            'currency' => $this->amount->currency->value,
            'amount' => $this->amount->amount,
            'cost_center_budget_id' => $this->costCenterBudgetID->value,
            'voucher_id' => $this->voucherID->value,
            'created_at' => $this->createdAt->toDateTimeString(),
            'updated_at' => $this->updatedAt->toDateTimeString(),
        ];
    }
}
