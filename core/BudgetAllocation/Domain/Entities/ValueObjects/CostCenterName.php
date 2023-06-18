<?php

namespace Core\BudgetAllocation\Domain\Entities\ValueObjects;

class CostCenterName
{
    public readonly string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
