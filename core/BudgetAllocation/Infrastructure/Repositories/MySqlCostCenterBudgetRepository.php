<?php

namespace Core\BudgetAllocation\Infrastructure\Repositories;

use Carbon\Carbon;
use Core\BudgetAllocation\Domain\Entities\CostCenterBudget;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Currency;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Money;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetRepository;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\Period;
use Exception;
use Illuminate\Support\Facades\DB;

class MySqlCostCenterBudgetRepository implements CostCenterBudgetRepository
{
    public function store(CostCenterBudget $costCenterBudget): void
    {
        DB::table('cost_center_budgets')
            ->insert($costCenterBudget->toArray());
    }

    public function existsByPeriodAndCostCenterID(Period $period, CostCenterID $costCenterID): bool
    {
        return DB::table('cost_center_budgets')
            ->where('period', $period->toPurchaseRecordFormat())
            ->where('cost_center_id', $costCenterID->value)
            ->exists();
    }

    /**
     * @param Period $period
     * @param CostCenterCode $costCenterCode
     * @return CostCenterBudget
     * @throws Exception
     */
    public function getByPeriodAndCostCenterCode(Period $period, CostCenterCode $costCenterCode): CostCenterBudget
    {
        $costCenterBudget = DB::table('cost_center_budgets')
            ->select([
                'cost_center_budgets.id',
                'cost_center_budgets.period',
                'cost_center_budgets.currency',
                'cost_center_budgets.amount',
                'cost_center_budgets.cost_center_id',
                'cost_center_budgets.created_at',
                'cost_center_budgets.updated_at',
            ])
            ->join(
                'cost_centers',
                'cost_centers.id',
                '=',
                'cost_center_budgets.cost_center_id'
            )
            ->where('cost_center_budgets.period', $period->toPurchaseRecordFormat())
            ->where('cost_centers.code', $costCenterCode->value)
            ->first();

        if (is_null($costCenterBudget)) {
            throw new Exception('cost center budget not found by period and cost center code');
        }

        return new CostCenterBudget(
            new CostCenterBudgetID($costCenterBudget->id),
            Period::fromPurchaseRecordFormat($costCenterBudget->period),
            new Money(
                new Currency($costCenterBudget->currency),
                $costCenterBudget->amount,
            ),
            new CostCenterID($costCenterBudget->cost_center_id),
            Carbon::parse($costCenterBudget->created_at),
            Carbon::parse($costCenterBudget->updated_at),
        );
    }

    public function getCostCenterBudgets(CostCenterID $costCenterID, int $page, ?int $perPage = null): array
    {
        $builder = DB::table('cost_center_budgets')
            ->where('cost_center_id', $costCenterID->value);

        if (is_null($perPage)) {
            return $builder->get()
                ->reduce(function (array $costCenterBudgets, $costCenterBudget) {
                    $costCenterBudgets[] = new CostCenterBudget(
                        new CostCenterBudgetID($costCenterBudget->id),
                        Period::fromPurchaseRecordFormat($costCenterBudget->period),
                        new Money(
                            new Currency($costCenterBudget->currency),
                            $costCenterBudget->amount,
                        ),
                        new CostCenterID($costCenterBudget->cost_center_id),
                        Carbon::parse($costCenterBudget->created_at),
                        Carbon::parse($costCenterBudget->updated_at),
                    );
                    return $costCenterBudgets;
                }, []);
        }

        return collect($builder->paginate($perPage, '*', 'page', $page)->items())
            ->reduce(function (array $costCenterBudgets, $costCenterBudget) {
                $costCenterBudgets[] = new CostCenterBudget(
                    new CostCenterBudgetID($costCenterBudget->id),
                    Period::fromPurchaseRecordFormat($costCenterBudget->period),
                    new Money(
                        new Currency($costCenterBudget->currency),
                        $costCenterBudget->amount,
                    ),
                    new CostCenterID($costCenterBudget->cost_center_id),
                    Carbon::parse($costCenterBudget->created_at),
                    Carbon::parse($costCenterBudget->updated_at),
                );
                return $costCenterBudgets;
            }, []);
    }

    public function getTotalPages(CostCenterID $costCenterID, int $perPage): int
    {
        $total = DB::table('cost_center_budgets')
            ->where('cost_center_id', $costCenterID->value)
            ->count('id');

        return ceil($total / $perPage);
    }

    public function updateAmount(Money $newAmount, CostCenterBudgetID $costCenterBudgetID): void
    {
        DB::table('cost_center_budgets')
            ->where('id', $costCenterBudgetID->value)
            ->update([
                'amount' => $newAmount->amount
            ]);
    }
}
