<?php

namespace Core\PurchaseRecords\Application\EventBus;

use Core\Inventory\Application\Listeners\ToInventory;
use Core\PurchaseRecords\Application\Events\PurchaseRecordCreated;
use Exception;
use Illuminate\Support\Facades\Log;

class EventBus
{
    private ToInventory $toInventory;

    public function __construct(ToInventory $toInventory)
    {
        $this->toInventory = $toInventory;
    }

    public function dispatch(PurchaseRecordCreated $event): void
    {
        try {
            $this->toInventory->handle($event);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
