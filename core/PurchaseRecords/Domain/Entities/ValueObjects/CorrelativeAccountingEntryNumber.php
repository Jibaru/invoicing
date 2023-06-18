<?php

namespace Core\PurchaseRecords\Domain\Entities\ValueObjects;

class CorrelativeAccountingEntryNumber
{
    public const ORDER = 2;
    public const PREFIX_WITH_BUDGET = '51';
    public const PREFIX_WITHOUT_BUDGET = '31';

    public readonly int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function format(bool $hasBudget): string
    {
        $prefix = $hasBudget
            ? self::PREFIX_WITH_BUDGET
            : self::PREFIX_WITHOUT_BUDGET;
        return $prefix . str_pad($this->value, 10, '0', STR_PAD_LEFT);
    }
}
