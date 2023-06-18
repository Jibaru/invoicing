<?php

namespace Core\Vouchers\Infrastructure;

use App\Http\Controllers\Controller;
use Core\BudgetAllocation\Domain\Entities\ValueObjects\CostCenterCode;
use Core\Vouchers\Application\StoreInvoiceUseCase;
use Core\Vouchers\Infrastructure\Resources\VoucherResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreInvoiceHandler extends Controller
{
    private StoreInvoiceUseCase $storeInvoiceUseCase;

    public function __construct(StoreInvoiceUseCase $storeInvoiceUseCase)
    {
        $this->storeInvoiceUseCase = $storeInvoiceUseCase;
    }

    public function __invoke(Request $request): Response
    {
        $files = $request->file('file');
        $costCenterCode = $request->input('cost_center_code');
        $hasBudget = (bool) $request->input('has_budget');

        $vouchers = [];

        try {
            foreach ($files as $file) {
                $xmlContents = file_get_contents($file);
                $vouchers[] = $this->storeInvoiceUseCase->__invoke(
                    $xmlContents,
                    new CostCenterCode($costCenterCode),
                    $hasBudget,
                );
            }
        } catch (Exception $exception) {
            return response(
                [
                    'message' => $exception->getMessage(),
                ],
                400
            );
        }

        return response(
            [
                'data' => VoucherResource::collection($vouchers),
            ],
            201
        );
    }
}
