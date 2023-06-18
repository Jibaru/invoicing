<?php

namespace Core\BudgetAllocation\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCostCenterBudgetsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => ['int', 'gt:0', 'sometimes'],
            'paginate' => ['int', 'gt:0', 'sometimes'],
        ];
    }
}
