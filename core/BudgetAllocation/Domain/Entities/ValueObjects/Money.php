<?php

namespace Core\BudgetAllocation\Domain\Entities\ValueObjects;

class Money
{
    public readonly Currency $currency;
    public readonly float $amount;

    public function __construct(Currency $currency, float $amount)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function isGreaterThan(Money $other): bool
    {
        return $this->amount > $other->amount;
    }

    public function subtract(Money $other): Money
    {
        return new Money(
            $this->currency,
            $this->amount - $other->amount,
        );
    }
}
