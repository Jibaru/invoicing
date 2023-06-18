<?php

namespace Core\Vouchers\Application\EventBus;

use Core\BudgetAllocation\Application\Listeners\HandleBudgetOnCostCenter;
use Core\PurchaseRecords\Application\Listeners\CreatePurchaseRecord;
use Core\PurchaseRecords\Application\UseCases\CreatePurchaseRecordUseCase;
use Core\Vouchers\Application\Events\VoucherCreated;
use Exception;

class EventBus
{
    private CreatePurchaseRecord $createPurchaseRecordListener;
    private HandleBudgetOnCostCenter $handleBudgetOnCostCenterListener;

    public function __construct(
        CreatePurchaseRecord $createPurchaseRecordListener,
        HandleBudgetOnCostCenter $handleBudgetOnCostCenterListener
    ) {
        $this->createPurchaseRecordListener = $createPurchaseRecordListener;
        $this->handleBudgetOnCostCenterListener = $handleBudgetOnCostCenterListener;
    }

    /**
     * @param VoucherCreated $event
     * @return void
     * @throws Exception
     */
    public function dispatch(VoucherCreated $event): void
    {
        $this->createPurchaseRecordListener->handle($event);
        $this->handleBudgetOnCostCenterListener->handle($event);
    }
}
