<?php

namespace Core\BudgetAllocation\Domain\Entities\ValueObjects;

class Currency
{
    public readonly string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function peruvianNewSoles(): self
    {
        return new self('PEN');
    }

    public function dollars(): self
    {
        return new self('USD');
    }
}
