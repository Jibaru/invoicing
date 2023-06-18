<?php

namespace Core\PurchaseRecords\Domain\Entities\Factories;

use Core\PurchaseRecords\Domain\Entities\Builders\PurchaseRecordBuilder;
use Core\PurchaseRecords\Domain\Entities\Builders\SunatPurchaseRecordBuilder;
use Core\PurchaseRecords\Domain\Repositories\PurchaseRecordRepository;
use Core\Vouchers\Domain\Entities\ValueObjects\VoucherID;

class SunatPurchaseRecordFactory
{
    private PurchaseRecordRepository $purchaseRecordRepository;

    public function __construct(PurchaseRecordRepository $purchaseRecordRepository)
    {
        $this->purchaseRecordRepository = $purchaseRecordRepository;
    }

    public function makeBuilder(VoucherID $voucherID, bool $hasBudget): PurchaseRecordBuilder
    {
        return new SunatPurchaseRecordBuilder($voucherID, $hasBudget, $this->purchaseRecordRepository);
    }
}