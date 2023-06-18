<?php

namespace App\Providers;

use Core\Auth\Domain\Repositories\PermissionRepository;
use Core\Auth\Domain\Repositories\UserRepository;
use Core\Auth\Infrastructure\Repositories\MySqlPermissionRepository;
use Core\Auth\Infrastructure\Repositories\MySqlUserRepository;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetExpenseRepository;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetRepository;
use Core\BudgetAllocation\Domain\Repositories\CostCenterRepository;
use Core\BudgetAllocation\Infrastructure\Repositories\MySqlCostCenterBudgetExpenseRepository;
use Core\BudgetAllocation\Infrastructure\Repositories\MySqlCostCenterBudgetRepository;
use Core\BudgetAllocation\Infrastructure\Repositories\MySqlCostCenterRepository;
use Core\Inventory\Domain\Repositories\SupplierItemRepository;
use Core\Inventory\Domain\Repositories\SupplierRepository;
use Core\Inventory\Infrastructure\Repositories\MySqlSupplierItemRepository;
use Core\Inventory\Infrastructure\Repositories\MySqlSupplierRepository;
use Core\PurchaseRecords\Application\Exportables\CompletePurchaseRecordsExportable;
use Core\PurchaseRecords\Application\Exportables\PurchaseRecordsExportable;
use Core\PurchaseRecords\Domain\Repositories\PurchaseRecordRepository;
use Core\PurchaseRecords\Infrastructure\Repositories\MySqlPurchaseRecordRepository;
use Core\Vouchers\Domain\Repositories\VoucherRepository;
use Core\Vouchers\Infrastructure\Repositories\MySqlVoucherRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VoucherRepository::class, MySqlVoucherRepository::class);
        $this->app->bind(PermissionRepository::class, MySqlPermissionRepository::class);
        $this->app->bind(PurchaseRecordRepository::class, MySqlPurchaseRecordRepository::class);
        $this->app->bind(UserRepository::class, MySqlUserRepository::class);
        $this->app->bind(PurchaseRecordsExportable::class, CompletePurchaseRecordsExportable::class);
        $this->app->bind(SupplierRepository::class, MySqlSupplierRepository::class);
        $this->app->bind(SupplierItemRepository::class, MySqlSupplierItemRepository::class);
        $this->app->bind(CostCenterRepository::class, MySqlCostCenterRepository::class);
        $this->app->bind(CostCenterBudgetRepository::class, MySqlCostCenterBudgetRepository::class);
        $this->app->bind(CostCenterBudgetExpenseRepository::class, MySqlCostCenterBudgetExpenseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
