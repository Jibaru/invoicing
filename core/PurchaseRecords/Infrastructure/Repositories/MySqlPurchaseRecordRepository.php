<?php

namespace Core\PurchaseRecords\Infrastructure\Repositories;

use Carbon\Carbon;
use Core\PurchaseRecords\Domain\Dtos\PurchaseRecordDTO;
use Core\PurchaseRecords\Domain\Entities\PurchaseRecord;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\CorrelativeAccountingEntryNumber;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\DailyOperationsTotalAmount;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\DayMonthYearDate;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\Detraction;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\DuaOrDsiIssueYear;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\IgvAmount;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\Period;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\PurchaseRecordID;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\SummaryAmount;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\SupplierDocumentDenomination;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\SupplierDocumentNumber;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\SupplierDocumentType;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\TaxBase;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\UniqueOperationCode;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\VoucherNumber;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\VoucherSeries;
use Core\PurchaseRecords\Domain\Entities\ValueObjects\VoucherType;
use Core\PurchaseRecords\Domain\Repositories\PurchaseRecordRepository;
use Core\PurchaseRecords\Domain\Repositories\Specifications\PeriodSpecification;
use Core\PurchaseRecords\Domain\Repositories\Specifications\Specification;
use Core\PurchaseRecords\Infrastructure\Repositories\Facades\MySqlPeriodSpecificationFacade;
use Core\Vouchers\Domain\Entities\ValueObjects\VoucherID;
use Exception;
use Illuminate\Support\Facades\DB;

class MySqlPurchaseRecordRepository implements PurchaseRecordRepository
{
    public function store(PurchaseRecord $purchaseRecord): void
    {
        DB::table('purchase_records')
            ->insert($purchaseRecord->toArray());
    }

    public function getPurchaseRecordsRows(int $page, ?int $perPage = null, ?Specification $specification = null): array
    {
        $builder = DB::table('purchase_records')
            ->orderByDesc('created_at');

        if ($specification instanceof PeriodSpecification) {
            [$field, $op, $value] = (new MySqlPeriodSpecificationFacade($specification))->toMySqlCondition();
            $builder->where($field, $op, $value);
        }

        if (is_null($perPage)) {
            return $builder
                ->get()
                ->reduce(function (array &$purchaseRecords, $record) {
                    $purchaseRecords[] = PurchaseRecordDTO::hydrate($record);
                    return $purchaseRecords;
                }, []);
        }

        $purchaseRecords = $builder
            ->paginate($perPage, '*', 'page', $page)
            ->items();

        if (empty($purchaseRecords)) {
            return [];
        }

        return collect($purchaseRecords)->reduce(function (array &$purchaseRecords, $record) {
            $purchaseRecords[] = PurchaseRecordDTO::hydrate($record);
            return $purchaseRecords;
        }, []);
    }

    public function getTotalPages(int $perPage, ?Specification $specification = null): int
    {
        $builder = DB::table('purchase_records');

        if ($specification instanceof PeriodSpecification) {
            [$field, $op, $value] = (new MySqlPeriodSpecificationFacade($specification))->toMySqlCondition();
            $builder->where($field, $op, $value);
        }

        $total = $builder->count('id');
        return ceil($total / $perPage);
    }

    public function nextEntryNumber(bool $hasBudget): int
    {
        $currentMaxEntryNumber = DB::table('purchase_records')
            ->where('has_budget', $hasBudget)
            ->max('purchase_records.correlative_accounting_entry_number') ?? 0;

        return $currentMaxEntryNumber + 1;
    }

    /**
     * @param VoucherID $voucherID
     * @return PurchaseRecord
     * @throws Exception
     */
    public function getByVoucherID(VoucherID $voucherID): PurchaseRecord
    {
        $p = DB::table('purchase_records')
            ->where('voucher_id', $voucherID->value)
            ->first();

        if (is_null($p)) {
            throw new Exception('purchase record not found');
        }

        return new PurchaseRecord(
            new PurchaseRecordID($p->id),
            new VoucherID($p->voucher_id),
            Period::fromPurchaseRecordFormat($p->period),
            new UniqueOperationCode($p->unique_operation_code),
            new CorrelativeAccountingEntryNumber($p->correlative_accounting_entry_number),
            DayMonthYearDate::fromPurchaseRecordFormat($p->issue_date),
            isset($p->due_date)
                ? DayMonthYearDate::fromYearMonthDay($p->due_date)
                : null,
            VoucherType::make($p->voucher_type),
            isset($p->voucher_series)
                ? new VoucherSeries($p->voucher_series)
                : null,
            isset($p->dua_or_dsi_issue_year)
                ? DuaOrDsiIssueYear::make($p->dua_or_dsi_issue_year)
                : null,
            new VoucherNumber($p->voucher_number),
            isset($p->daily_operations_total_amount)
                ? DailyOperationsTotalAmount::make($p->daily_operations_total_amount)
                : null,
            isset($p->supplier_document_type)
                ? SupplierDocumentType::make($p->supplier_document_type)
                : null,
            isset($p->supplier_document_number)
                ? SupplierDocumentNumber::make($p->supplier_document_number)
                : null,
            isset($p->supplier_document_denomination)
                ? SupplierDocumentDenomination::make($p->supplier_document_denomination)
                : null,
            isset($p->first_tax_base) ? TaxBase::make($p->first_tax_base) : null,
            isset($p->first_igv_amount) ? IgvAmount::make($p->first_igv_amount): null,
            isset($p->second_tax_base) ? TaxBase::make($p->second_tax_base) : null,
            isset($p->second_igv_amount) ? IgvAmount::make($p->second_igv_amount): null,
            isset($p->third_tax_base) ? TaxBase::make($p->third_tax_base) : null,
            isset($p->third_igv_amount) ? IgvAmount::make($p->third_igv_amount): null,
            SummaryAmount::make($p->payable_amount),
            $p->has_detraction,
            isset($p->detraction_percentage) ? new Detraction($p->detraction_percentage) : null,
            $p->has_budget,
            Carbon::parse($p->created_at),
            Carbon::parse($p->updated_at),
        );
    }
}
