<?php

namespace Core\Vouchers\Application\Parser\Values;

use stdClass;
use Core\Vouchers\Application\Parser\Values\Contracts\Arrayable;
use Core\Vouchers\Application\Parser\Values\Helpers\Filler;
use Core\Vouchers\Application\Parser\Values\Traits\IsArrayable;

class Invoice implements Arrayable
{
    use IsArrayable;

    public readonly ID $ID;
    public readonly ID $ublVersionID;
    public readonly ID $customizationID;
    public readonly Date $issueDate;
    public readonly Time $issueTime;
    public readonly ?Date $dueDate;
    public readonly InvoiceTypeCode $invoiceTypeCode;
    public readonly ?DocumentCurrencyCode $documentCurrencyCode;

    public readonly AccountingSupplier $accountingSupplier;
    public readonly AccountingCustomer $accountingCustomer;
    public readonly BuyerCustomer $buyerCustomer;

    public readonly TaxTotal $taxTotal;
    public readonly LegalMonetaryTotal $legalMonetaryTotal;

    /**
     * @var Note[]
     */
    public readonly array $notes;

    /**
     * @var AdditionalDocumentReference[]
     */
    public readonly array $additionalDocumentReferences;

    /**
     * @var PaymentTerm[]
     */
    public readonly array $paymentTerms;

    /**
     * @var PaymentMean[]
     */
    public readonly array $paymentMeans;

    /**
     * @var InvoiceLine[]
     */
    public readonly array $invoiceLines;

    public function __construct(
        ID $ID,
        ID $ublVersionID,
        ID $customizationID,
        Date $issueDate,
        Time $issueTime,
        InvoiceTypeCode $invoiceTypeCode,
        ?DocumentCurrencyCode $documentCurrencyCode,
        AccountingSupplier $accountingSupplier,
        AccountingCustomer $accountingCustomer,
        BuyerCustomer $buyerCustomer,
        TaxTotal $taxTotal,
        LegalMonetaryTotal $legalMonetaryTotal,
        array $notes,
        array $additionalDocumentReferences,
        array $paymentMeans,
        array $paymentTerms,
        array $invoiceLines,
        ?Date $dueDate
    ) {
        $this->ID = $ID;
        $this->ublVersionID = $ublVersionID;
        $this->customizationID = $customizationID;
        $this->issueDate = $issueDate;
        $this->issueTime = $issueTime;
        $this->invoiceTypeCode = $invoiceTypeCode;
        $this->documentCurrencyCode = $documentCurrencyCode;
        $this->accountingSupplier = $accountingSupplier;
        $this->accountingCustomer = $accountingCustomer;
        $this->buyerCustomer = $buyerCustomer;
        $this->taxTotal = $taxTotal;
        $this->legalMonetaryTotal = $legalMonetaryTotal;
        $this->notes = $notes;
        $this->additionalDocumentReferences = $additionalDocumentReferences;
        $this->paymentMeans = $paymentMeans;
        $this->paymentTerms = $paymentTerms;
        $this->invoiceLines = $invoiceLines;
        $this->dueDate = $dueDate;
    }

    public static function hydrate(array|stdClass $from): self
    {
        $obj = (object) $from;
        Filler::withNull($obj, self::class);

        return new self(
            $obj->ID instanceof ID
                ? $obj->ID
                : ID::hydrate($obj->ID),
            $obj->ublVersionID instanceof ID
                ? $obj->ublVersionID
                : ID::hydrate($obj->ublVersionID),
            $obj->customizationID instanceof ID
                ? $obj->customizationID
                : ID::hydrate($obj->customizationID),
            $obj->issueDate instanceof Date
                ? $obj->issueDate
                : Date::hydrate($obj->issueDate),
            $obj->issueTime instanceof Time
                ? $obj->issueTime
                : Time::hydrate($obj->issueTime),
            $obj->invoiceTypeCode instanceof InvoiceTypeCode
                ? $obj->invoiceTypeCode
                : InvoiceTypeCode::hydrate($obj->invoiceTypeCode),
            $obj->documentCurrencyCode instanceof DocumentCurrencyCode || is_null($obj->documentCurrencyCode)
                ? $obj->documentCurrencyCode
                : DocumentCurrencyCode::hydrate($obj->documentCurrencyCode),
            $obj->accountingSupplier instanceof AccountingSupplier
                ? $obj->accountingSupplier
                : AccountingSupplier::hydrate($obj->accountingSupplier),
            $obj->accountingCustomer instanceof AccountingCustomer
                ? $obj->accountingCustomer
                : AccountingCustomer::hydrate($obj->accountingCustomer),
            $obj->buyerCustomer instanceof BuyerCustomer
                ? $obj->buyerCustomer
                : BuyerCustomer::hydrate($obj->buyerCustomer),
            $obj->taxTotal instanceof TaxTotal
                ? $obj->taxTotal
                : TaxTotal::hydrate($obj->taxTotal),
            $obj->legalMonetaryTotal instanceof LegalMonetaryTotal
                ? $obj->legalMonetaryTotal
                : LegalMonetaryTotal::hydrate($obj->legalMonetaryTotal),
            collect($obj->notes)->map(function ($note) {
                if ($note instanceof Note) {
                    return $note;
                }

                return Note::hydrate($note);
            })->toArray(),
            collect($obj->additionalDocumentReferences)->map(function ($additionalDocumentReference) {
                if ($additionalDocumentReference instanceof AdditionalDocumentReference) {
                    return $additionalDocumentReference;
                }

                return AdditionalDocumentReference::hydrate($additionalDocumentReference);
            })->toArray(),
            collect($obj->paymentMeans)->map(function ($mean) {
                if ($mean instanceof PaymentMean) {
                    return $mean;
                }

                return PaymentMean::hydrate($mean);
            })->toArray(),
            collect($obj->paymentTerms)->map(function ($paymentTerm) {
                if ($paymentTerm instanceof PaymentTerm) {
                    return $paymentTerm;
                }

                return PaymentTerm::hydrate($paymentTerm);
            })->toArray(),
            collect($obj->invoiceLines)->map(function ($invoiceLine) {
                if ($invoiceLine instanceof InvoiceLine) {
                    return $invoiceLine;
                }

                return InvoiceLine::hydrate($invoiceLine);
            })->toArray(),
            $obj->dueDate instanceof Date || is_null($obj->dueDate)
                ? $obj->dueDate
                : Date::hydrate($obj->dueDate),
        );
    }
}
