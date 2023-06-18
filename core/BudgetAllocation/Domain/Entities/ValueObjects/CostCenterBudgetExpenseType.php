<?php

namespace Core\BudgetAllocation\Domain\Entities\ValueObjects;

class CostCenterBudgetExpenseType
{
    public readonly string $value;
    public const TYPE_SERVICE = '43';
    public const TYPE_GOOD = '45';

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function service(): self
    {
        return new self(self::TYPE_SERVICE);
    }

    public static function good(): self
    {
        return new self(self::TYPE_GOOD);
    }
}
