<?php

namespace Core\PurchaseRecords\Application\Events;

use Core\PurchaseRecords\Domain\Entities\PurchaseRecord;

class PurchaseRecordCreated
{
    public readonly PurchaseRecord $purchaseRecord;

    public function __construct(PurchaseRecord $purchaseRecord)
    {
        $this->purchaseRecord = $purchaseRecord;
    }
}
