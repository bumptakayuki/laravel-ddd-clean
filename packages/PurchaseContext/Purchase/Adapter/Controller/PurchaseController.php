<?php
namespace Packages\PurchaseContext\Purchase\Adapter\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\PurchaseContext\Purchase\UseCase\ConfirmPurchase\IConfirmPurchaseUseCase;
use Packages\PurchaseContext\Purchase\UseCase\ConfirmPurchase\ConfirmPurchaseInputData;
use Packages\PurchaseContext\Purchase\UseCase\GetPurchase\IGetPurchaseUseCase;
use Packages\PurchaseContext\Purchase\UseCase\GetPurchase\GetPurchaseInputData;
use Packages\PurchaseContext\Purchase\UseCase\ListPurchases\IListPurchasesUseCase;
use Packages\PurchaseContext\Purchase\UseCase\ListPurchases\ListPurchasesInputData;

class PurchaseController extends Controller
{
    public function __construct(
        private readonly IConfirmPurchaseUseCase $confirmPurchaseUseCase,
        private readonly IGetPurchaseUseCase $getPurchaseUseCase,
        private readonly IListPurchasesUseCase $listPurchasesUseCase
    ) {}
    
    /**
     * 購入を確定する
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);
        
        $input = new ConfirmPurchaseInputData($request->input('order_id'));
        $output = $this->confirmPurchaseUseCase->handle($input);
        
        return response()->json([
            'purchase_id' => $output->purchaseId,
            'message' => $output->message,
        ], 201);
    }
    
    /**
     * 購入情報を取得する
     */
    public function show(string $purchaseId)
    {
        $input = new GetPurchaseInputData($purchaseId);
        $output = $this->getPurchaseUseCase->handle($input);
        
        return response()->json([
            'purchase_id' => $output->purchaseId,
            'order_id' => $output->orderId,
            'confirmed_at' => $output->confirmedAt,
        ]);
    }
    
    /**
     * 購入一覧を取得する
     */
    public function index(Request $request)
    {
        $request->validate([
            'member_id' => 'required|string',
        ]);
        
        $input = new ListPurchasesInputData($request->input('member_id'));
        $output = $this->listPurchasesUseCase->handle($input);
        
        return response()->json($output->purchases);
    }
}

