<?php

namespace Core\BudgetAllocation\Application\Listeners;

use Core\BudgetAllocation\Domain\Entities\Factories\CostCenterBudgetExpenseFactory;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Currency;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\Money;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetExpenseRepository;
use Core\BudgetAllocation\Domain\Repositories\CostCenterBudgetRepository;
use Core\PurchaseRecords\Domain\Repositories\PurchaseRecordRepository;
use Core\Vouchers\Application\Events\VoucherCreated;
use Exception;
use Illuminate\Support\Facades\Log;

class HandleBudgetOnCostCenter
{
    private CostCenterBudgetRepository $costCenterBudgetRepository;
    private PurchaseRecordRepository $purchaseRecordRepository;
    private CostCenterBudgetExpenseFactory $costCenterBudgetExpenseFactory;
    private CostCenterBudgetExpenseRepository $costCenterBudgetExpenseRepository;

    public function __construct(
        CostCenterBudgetRepository $costCenterBudgetRepository,
        PurchaseRecordRepository $purchaseRecordRepository,
        CostCenterBudgetExpenseFactory $costCenterBudgetExpenseFactory,
        CostCenterBudgetExpenseRepository $costCenterBudgetExpenseRepository
    ) {
        $this->costCenterBudgetRepository = $costCenterBudgetRepository;
        $this->purchaseRecordRepository = $purchaseRecordRepository;
        $this->costCenterBudgetExpenseFactory = $costCenterBudgetExpenseFactory;
        $this->costCenterBudgetExpenseRepository = $costCenterBudgetExpenseRepository;
    }

    public function handle(VoucherCreated $event): void
    {
        $voucher = $event->voucher;
        $costCenterCode = $event->costCenterCode;

        try {
            $purchaseRecord = $this->purchaseRecordRepository->getByVoucherID($voucher->id);
            $costCenterBudget = $this->costCenterBudgetRepository->getByPeriodAndCostCenterCode(
                $purchaseRecord->period(),
                $costCenterCode,
            );

            $totalAmount = new Money(
                new Currency($event->voucher->parseContent()->legalMonetaryTotal->payableAmount->currencyID),
                $voucher->parseContent()->legalMonetaryTotal->payableAmount->value
            );

            $costCenterBudgetExpense = $this->costCenterBudgetExpenseFactory->make(
                false, // TODO: CHANGE HERE
                $totalAmount,
                $costCenterBudget->id,
                $voucher->id,
            );

            $this->costCenterBudgetExpenseRepository->store($costCenterBudgetExpense);

            $this->costCenterBudgetRepository->updateAmount(
                $costCenterBudget->amount->subtract($totalAmount),
                $costCenterBudget->id,
            );
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
