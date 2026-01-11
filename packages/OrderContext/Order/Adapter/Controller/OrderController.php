<?php
namespace Packages\OrderContext\Order\Adapter\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\OrderContext\Order\UseCase\CreateOrder\ICreateOrderUseCase;
use Packages\OrderContext\Order\UseCase\CreateOrder\CreateOrderInputData;
use Packages\OrderContext\Order\UseCase\CreateOrder\CreateOrderItemInputData;
use Packages\OrderContext\Order\UseCase\ListOrders\IListOrdersUseCase;
use Packages\OrderContext\Order\UseCase\ListOrders\ListOrdersInputData;
use Packages\OrderContext\Order\UseCase\CreatePayment\ICreatePaymentUseCase;
use Packages\OrderContext\Order\UseCase\CreatePayment\CreatePaymentInputData;
use Packages\OrderContext\Order\UseCase\CreateAcceptance\ICreateAcceptanceUseCase;
use Packages\OrderContext\Order\UseCase\CreateAcceptance\CreateAcceptanceInputData;
use Packages\OrderContext\Order\UseCase\CreatePurchase\ICreatePurchaseUseCase;
use Packages\OrderContext\Order\UseCase\CreatePurchase\CreatePurchaseInputData;

class OrderController extends Controller
{
    public function __construct(
        private readonly ICreateOrderUseCase $createOrderUseCase,
        private readonly IListOrdersUseCase $listOrdersUseCase,
        private readonly ICreatePaymentUseCase $createPaymentUseCase,
        private readonly ICreateAcceptanceUseCase $createAcceptanceUseCase,
        private readonly ICreatePurchaseUseCase $createPurchaseUseCase
    ) {}
    
    /**
     * 注文を作成する
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|string',
            'store_id' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.configuration_id' => 'required|string',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        
        $items = [];
        foreach ($request->input('items') as $item) {
            $items[] = new CreateOrderItemInputData(
                $item['configuration_id'],
                (float)$item['unit_price'],
                (int)$item['quantity']
            );
        }
        
        $input = new CreateOrderInputData(
            $request->input('member_id'),
            $request->input('store_id'),
            $items
        );
        
        $output = $this->createOrderUseCase->handle($input);
        
        return response()->json([
            'order_id' => $output->orderId,
            'message' => $output->message,
        ], 201);
    }
    
    /**
     * 注文一覧を取得する
     */
    public function index(Request $request)
    {
        $request->validate([
            'member_id' => 'required|string',
        ]);
        
        $input = new ListOrdersInputData($request->input('member_id'));
        $output = $this->listOrdersUseCase->handle($input);
        
        return response()->json($output->orders);
    }
    
    /**
     * 決済を実行する
     */
    public function createPayment(Request $request, string $orderId)
    {
        $request->validate([
            'method' => 'required|string',
            'transaction_id' => 'nullable|string',
        ]);
        
        $input = new CreatePaymentInputData(
            $orderId,
            $request->input('method'),
            $request->input('transaction_id')
        );
        
        $output = $this->createPaymentUseCase->handle($input);
        
        return response()->json([
            'payment_id' => $output->paymentId,
            'message' => $output->message,
        ], 201);
    }
    
    /**
     * 注文を受注する
     */
    public function createAcceptance(string $orderId)
    {
        $input = new CreateAcceptanceInputData($orderId);
        $output = $this->createAcceptanceUseCase->handle($input);
        
        return response()->json([
            'acceptance_id' => $output->acceptanceId,
            'message' => $output->message,
        ], 201);
    }
    
    /**
     * 購入を確定する
     */
    public function createPurchase(string $orderId)
    {
        $input = new CreatePurchaseInputData($orderId);
        $output = $this->createPurchaseUseCase->handle($input);
        
        return response()->json([
            'purchase_id' => $output->purchaseId,
            'message' => $output->message,
        ], 201);
    }
}

