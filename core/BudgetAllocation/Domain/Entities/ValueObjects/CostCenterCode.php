<?php

namespace Core\BudgetAllocation\Domain\Entities\ValueObjects;

class CostCenterCode
{
    public readonly string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
