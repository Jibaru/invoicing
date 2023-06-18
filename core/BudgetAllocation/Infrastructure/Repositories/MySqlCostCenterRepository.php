<?php

namespace Core\BudgetAllocation\Infrastructure\Repositories;

use Carbon\Carbon;
use Core\BudgetAllocation\Domain\Entities\CostCenter;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterID;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterName;
use Core\BudgetAllocation\Domain\Repositories\CostCenterRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class MySqlCostCenterRepository implements CostCenterRepository
{

    public function store(CostCenter $costCenter): void
    {
        DB::table('cost_centers')
            ->insert($costCenter->toArray());
    }

    public function getCostCenters(int $page, ?int $perPage = null): array
    {
        $builder = DB::table('cost_centers');

        if (is_null($perPage)) {
            return $builder
                ->get()
                ->reduce(function (array $costCenters, $costCenter) {
                    $costCenters[] = new CostCenter(
                        new CostCenterID($costCenter->id),
                        new CostCenterCode($costCenter->code),
                        new CostCenterName($costCenter->name),
                        Carbon::parse($costCenter->created_at),
                        Carbon::parse($costCenter->updated_at),
                    );
                    return $costCenters;
                }, []);
        }

        return collect($builder->paginate($perPage, '*', 'page', $page)->items())
            ->reduce(function (array $costCenters, $costCenter) {
                $costCenters[] = new CostCenter(
                    new CostCenterID($costCenter->id),
                    new CostCenterCode($costCenter->code),
                    new CostCenterName($costCenter->name),
                    Carbon::parse($costCenter->created_at),
                    Carbon::parse($costCenter->updated_at),
                );
                return $costCenters;
            }, []);
    }

    public function getTotalPages(int $perPage): int
    {
        $total = DB::table('purchase_records')->count('id');
        return ceil($total / $perPage);
    }

    public function existsByCode(CostCenterCode $costCenterCode): bool
    {
        return DB::table('cost_centers')
            ->where('code', '=', $costCenterCode->value)
            ->exists();
    }

    /**
     * @param CostCenterID $costCenterID
     * @return CostCenter
     * @throws Exception
     */
    public function getByCostCenterID(CostCenterID $costCenterID): CostCenter
    {
        $costCenter = DB::table('cost_centers')
            ->where('id', $costCenterID->value)
            ->first();

        if (is_null($costCenter)) {
            throw new Exception('cost center not found');
        }

        return new CostCenter(
            new CostCenterID($costCenter->id),
            new CostCenterCode($costCenter->code),
            new CostCenterName($costCenter->name),
            Carbon::parse($costCenter->created_at),
            Carbon::parse($costCenter->updated_at),
        );
    }

    public function existsByCostCenterID(CostCenterID $costCenterID): bool
    {
        return DB::table('cost_centers')
            ->where('id', $costCenterID->value)
            ->exists();
    }

    /**
     * @param CostCenterCode $costCenterCode
     * @return CostCenter
     * @throws Exception
     */
    public function getByCostCenterCode(CostCenterCode $costCenterCode): CostCenter
    {
        $costCenter = DB::table('cost_centers')
            ->where('code', $costCenterCode->value)
            ->first();

        if (is_null($costCenter)) {
            throw new Exception('cost center not found by code');
        }

        return new CostCenter(
            new CostCenterID($costCenter->id),
            new CostCenterCode($costCenter->code),
            new CostCenterName($costCenter->name),
            Carbon::parse($costCenter->created_at),
            Carbon::parse($costCenter->updated_at),
        );
    }
}
