<?php

namespace Core\BudgetAllocation\Domain\Entities;

use Carbon\Carbon;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterName;

class CostCenter
{
    public readonly CostCenterID $id;
    private CostCenterCode $code;
    private CostCenterName $name;
    private Carbon $createdAt;
    private Carbon $updatedAt;

    public function __construct(
        CostCenterID $id,
        CostCenterCode $code,
        CostCenterName $name,
        Carbon $createdAt,
        Carbon $updatedAt,
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value,
            'code' => $this->code->value,
            'name' => $this->name->value,
            'created_at' => $this->createdAt->toDateTimeString(),
            'updated_at' => $this->updatedAt->toDateTimeString(),
        ];
    }
}
