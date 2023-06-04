<?php

namespace Core\PurchaseRecords\Application\UseCases;

use Core\PurchaseRecords\Application\EventBus\EventBus;
use Core\PurchaseRecords\Application\Events\PurchaseRecordCreated;
use Core\PurchaseRecords\Domain\Entities\Factories\SunatPurchaseRecordFactory;
use Core\PurchaseRecords\Domain\Entities\PurchaseRecord;
use Core\PurchaseRecords\Domain\Repositories\PurchaseRecordRepository;
use Core\Vouchers\Domain\Entities\Voucher;
use Exception;

class CreatePurchaseRecordUseCase
{
    private SunatPurchaseRecordFactory $sunatPurchaseRecordFactory;
    private PurchaseRecordRepository $purchaseRecordRepository;
    private EventBus $eventBus;

    public function __construct(
        SunatPurchaseRecordFactory $sunatPurchaseRecordFactory,
        PurchaseRecordRepository $purchaseRecordRepository,
        EventBus $eventBus
    ) {
        $this->sunatPurchaseRecordFactory = $sunatPurchaseRecordFactory;
        $this->purchaseRecordRepository = $purchaseRecordRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param Voucher $voucher
     * @return PurchaseRecord
     * @throws Exception
     */
    public function __invoke(Voucher $voucher): PurchaseRecord
    {
        $invoice = $voucher->parseContent();

        $builder = $this->sunatPurchaseRecordFactory->makeBuilder($voucher->id);
        $builder->setPeriodToNow();
        $builder->setIssueDateFromInvoice($invoice);
        $builder->setVoucherTypeFromInvoice($invoice);
        $builder->setDueDateFromInvoice($invoice);
        $builder->setVoucherSeriesFromInvoice($invoice);
        $builder->setDuaOrDsiIssueYearFromInvoice($invoice);
        $builder->setVoucherNumberFromInvoice($invoice);
        $builder->setDailyOperationsTotalAmountFromInvoice($invoice);
        $builder->setSupplierInformationFromInvoice($invoice);
        $builder->setTaxBasesAndIgvAmountsFromInvoice($invoice);
        $builder->setPayableAmountFromInvoice($invoice);
        $builder->setDetractionInformationFromInvoice($invoice);
        $purchaseRecord = $builder->build();

        $this->purchaseRecordRepository->store($purchaseRecord);

        $this->eventBus->dispatch(new PurchaseRecordCreated($purchaseRecord));

        return $purchaseRecord;
    }
}
