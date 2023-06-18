<?php

namespace Core\PurchaseRecords\Domain\Repositories;

use Core\PurchaseRecords\Domain\Entities\PurchaseRecord;
use Core\PurchaseRecords\Domain\Repositories\Specifications\Specification;
use Core\Vouchers\Domain\Entities\ValueObjects\VoucherID;
use Exception;

interface PurchaseRecordRepository
{
    public function store(PurchaseRecord $purchaseRecord): void;

    public function getPurchaseRecordsRows(int $page, ?int $perPage = null, ?Specification $specification = null): array;

    public function getTotalPages(int $perPage, ?Specification $specification = null): int;
    public function nextEntryNumber(bool $hasBudget): int;

    /**
     * @param VoucherID $voucherID
     * @return PurchaseRecord
     * @throws Exception
     */
    public function getByVoucherID(VoucherID $voucherID): PurchaseRecord;
}
