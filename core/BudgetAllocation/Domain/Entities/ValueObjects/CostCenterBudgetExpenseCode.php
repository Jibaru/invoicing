<?php

namespace Core\BudgetAllocation\Domain\Entities\ValueObjects;

class CostCenterBudgetExpenseCode
{
    public readonly string $value;
    public const PREFIX_SERVICES = '43';
    public const PREFIX_GOODS = '45';

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function asService(int $correlative): self
    {
        return new self(
            self::PREFIX_SERVICES . str_pad($correlative, 10, '0', STR_PAD_LEFT),
        );
    }

    public static function asGood(int $correlative): self
    {
        return new self(
            self::PREFIX_GOODS . str_pad($correlative, 10, '0', STR_PAD_LEFT),
        );
    }
}
