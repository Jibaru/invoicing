<?php

namespace Core\BudgetAllocation\Infrastructure\Repositories;

use Core\BudgetAllocation\Domain\Entities\CostCenterBudgetExpense;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseType;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetExpenseRepository;
use Illuminate\Support\Facades\DB;

class MySqlCostCenterBudgetExpenseRepository implements CostCenterBudgetExpenseRepository
{
    public function store(CostCenterBudgetExpense $costCenterBudgetExpense): void
    {
        DB::table('cost_center_budget_expenses')
            ->insert($costCenterBudgetExpense->toArray());
    }

    public function nextCode(CostCenterBudgetExpenseType $type): CostCenterBudgetExpenseCode
    {
        $currentMaxEntryNumber = DB::table('cost_center_budget_expenses')
                ->where('type', $type->value)
                ->max('cost_center_budget_expenses.code') ?? 0;

        return new CostCenterBudgetExpenseCode($currentMaxEntryNumber + 1);
    }
}
