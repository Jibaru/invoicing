<?php

namespace Core\BudgetAllocation\Domain\Repositories;

use Core\BudgetAllocation\Domain\Entities\CostCenterBudgetExpense;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseType;

interface CostCenterBudgetExpenseRepository
{
    public function store(CostCenterBudgetExpense $costCenterBudgetExpense): void;
    public function nextCode(CostCenterBudgetExpenseType $type): CostCenterBudgetExpenseCode;
}
