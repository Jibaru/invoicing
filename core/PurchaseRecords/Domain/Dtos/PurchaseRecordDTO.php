<?php

namespace Core\PurchaseRecords\Domain\Dtos;

use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterBudgetExpenseCode;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\CorrelativeAccountingEntryNumber;
use stdClass;

class PurchaseRecordDTO
{
    public readonly string $id;
    public readonly string $costCenterBudgetExpenseCode;
    public readonly string $costCenterCode;
    public readonly string $period;
    public readonly string $uniqueOperationCode;
    public readonly string $correlativeAccountingEntryNumber;
    public readonly string $issueDate;
    public readonly ?string $dueDate;
    public readonly string $voucherType;
    public readonly ?string $voucherSeries;
    public readonly ?string $duaOrDsiIssueYear;
    public readonly string $voucherNumber;
    public readonly ?string $dailyOperationsTotalAmount;
    public readonly ?string $supplierDocumentType;
    public readonly ?string $supplierDocumentNumber;
    public readonly ?string $supplierDocumentDenomination;
    public readonly ?float $firstTaxBase;
    public readonly ?float $firstIgvAmount;
    public readonly ?float $secondTaxBase;
    public readonly ?float $secondIgvAmount;
    public readonly ?float $thirdTaxBase;
    public readonly ?float $thirdIgvAmount;
    public readonly float $payableAmount;
    public readonly bool $hasDetraction;
    public readonly ?float $detractionPercentage;
    public readonly ?string $detractionType;

    public function __construct(
        string $id,
        string $costCenterBudgetExpenseCode,
        string $costCenterCode,
        string $period,
        string $uniqueOperationCode,
        string $correlativeAccountingEntryNumber,
        string $issueDate,
        ?string $dueDate,
        string $voucherType,
        ?string $voucherSeries,
        ?string $duaOrDsiIssueYear,
        string $voucherNumber,
        ?string $dailyOperationsTotalAmount,
        ?string $supplierDocumentType,
        ?string $supplierDocumentNumber,
        ?string $supplierDocumentDenomination,
        ?float $firstTaxBase,
        ?float $firstIgvAmount,
        ?float $secondTaxBase,
        ?float $secondIgvAmount,
        ?float $thirdTaxBase,
        ?float $thirdIgvAmount,
        float $payableAmount,
        bool $hasDetraction,
        ?float $detractionPercentage,
        bool $hasBudget,
    ) {
        $this->id = $id;
        $this->costCenterCode = $costCenterCode;
        $this->costCenterBudgetExpenseCode = $costCenterBudgetExpenseCode;
        $this->period = $period;
        $this->uniqueOperationCode = $uniqueOperationCode;
        $this->correlativeAccountingEntryNumber =
            (new CorrelativeAccountingEntryNumber($correlativeAccountingEntryNumber))->format($hasBudget);
        $this->issueDate = $issueDate;
        $this->dueDate = $dueDate;
        $this->voucherType = $voucherType;
        $this->voucherSeries = $voucherSeries;
        $this->duaOrDsiIssueYear = $duaOrDsiIssueYear;
        $this->voucherNumber = $voucherNumber;
        $this->dailyOperationsTotalAmount = $dailyOperationsTotalAmount;
        $this->supplierDocumentType = $supplierDocumentType;
        $this->supplierDocumentNumber = $supplierDocumentNumber;
        $this->supplierDocumentDenomination = $supplierDocumentDenomination;
        $this->firstTaxBase = $firstTaxBase;
        $this->firstIgvAmount = $firstIgvAmount;
        $this->secondTaxBase = $secondTaxBase;
        $this->secondIgvAmount = $secondIgvAmount;
        $this->thirdTaxBase = $thirdTaxBase;
        $this->thirdIgvAmount = $thirdIgvAmount;
        $this->payableAmount = $payableAmount;
        $this->hasDetraction = $hasDetraction;
        $this->detractionPercentage = $detractionPercentage;

        if ($this->detractionPercentage) {
            if ($this->detractionPercentage == 4) {
                $this->detractionType = 'Contratos de construcción';
            } elseif ($this->detractionPercentage == 10) {
                $this->detractionType = 'Transporte de bienes';
            } elseif ($this->detractionPercentage == 12) {
                $this->detractionType = 'Otros servicios empresariales';
            } else {
                $this->detractionType = null;
            }
        } else {
            $this->detractionType = null;
        }
    }

    public static function hydrate(array|stdClass $fields): self
    {
        $fields = (object) $fields;

        if ($fields->has_detraction) {
            $costCenterBudgetExpenseCode =
                (CostCenterBudgetExpenseCode::asDetraction($fields->cost_center_budget_expense_code))->value;
        } else {
            $costCenterBudgetExpenseCode =
                (CostCenterBudgetExpenseCode::asGood($fields->cost_center_budget_expense_code))->value;
        }

        return new self(
            $fields->id,
            $costCenterBudgetExpenseCode,
            $fields->cost_center_code,
            $fields->period,
            $fields->unique_operation_code,
            $fields->correlative_accounting_entry_number,
            $fields->issue_date,
            $fields->due_date,
            $fields->voucher_type,
            $fields->voucher_series,
            $fields->dua_or_dsi_issue_year,
            $fields->voucher_number,
            $fields->daily_operations_total_amount,
            $fields->supplier_document_type,
            $fields->supplier_document_number,
            $fields->supplier_document_denomination,
            $fields->first_tax_base,
            $fields->first_igv_amount,
            $fields->second_tax_base,
            $fields->second_igv_amount,
            $fields->third_tax_base,
            $fields->third_igv_amount,
            $fields->payable_amount,
            $fields->has_detraction,
            $fields->detraction_percentage,
            $fields->has_budget,
        );
    }
}
