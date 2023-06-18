<?php

namespace Core\BudgetAllocation\Domain\Entities;

use Carbon\Carbon;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Money;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\Period;

class CostCenterBudget
{
    public readonly CostCenterBudgetID $id;
    private Period $period;
    public readonly Money $amount;
    private CostCenterID $costCenterID;
    private Carbon $createdAt;
    private Carbon $updatedAt;

    public function __construct(
        CostCenterBudgetID $id,
        Period $period,
        Money $amount,
        CostCenterID $costCenterID,
        Carbon $createdAt,
        Carbon $updatedAt,
    ) {
        $this->id = $id;
        $this->period = $period;
        $this->amount = $amount;
        $this->costCenterID = $costCenterID;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value,
            'period' => $this->period->toPurchaseRecordFormat(),
            'currency' => $this->amount->currency->value,
            'amount' => $this->amount->amount,
            'cost_center_id' => $this->costCenterID->value,
            'created_at' => $this->createdAt->toDateTimeString(),
            'updated_at' => $this->updatedAt->toDateTimeString(),
        ];
    }
}
