<?php

namespace Core\BudgetAllocation\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCostCenterBudgetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'month' => [
                'required',
                'int',
                'gte:1',
                'lte:12',
            ],
            'year' => [
                'required',
                'int',
                'gte:1900',
            ],
            'amount' => [
                'required',
            ],
            'amount.currency' => [
                'required',
                'in:PEN,USD',
            ],
            'amount.value' => [
                'required',
                'gt:0',
            ],
        ];
    }
}
