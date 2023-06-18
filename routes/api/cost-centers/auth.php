<?php

use App\Http\Controllers\CostCenters\CostCenter\GetCostCenterBudgetsHandler;
use App\Http\Controllers\CostCenters\CostCenter\GetCostCenterHandler;
use App\Http\Controllers\CostCenters\CostCenter\StoreCostCenterBudgetHandler;
use App\Http\Controllers\CostCenters\GetCostCentersHandler;
use App\Http\Controllers\CostCenters\StoreCostCenterHandler;
use Core\Auth\Domain\Entities\ValueObjects\PermissionName;
use Illuminate\Support\Facades\Route;

Route::middleware('has-permission:' . PermissionName::MANAGE_BUDGET_ALLOCATIONS)->prefix('cost-centers')->group(
    function () {
        Route::post('/', StoreCostCenterHandler::class);
        Route::get('/', GetCostCentersHandler::class);
        Route::prefix('{costCenterID}')->group(
            function () {
                Route::get('/', GetCostCenterHandler::class);
                Route::prefix('budgets')->group(
                    function () {
                        Route::get('/', GetCostCenterBudgetsHandler::class);
                        Route::post('/', StoreCostCenterBudgetHandler::class);
                    }
                );
            }
        );
    }
);
