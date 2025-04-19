<?php
namespace Packages\Order\Order\Adapter\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Order\Order\UseCase\CreateOrder\ICreateOrderUseCase;
use Packages\Order\Order\UseCase\CreateOrder\CreateOrderInputData;

class OrderController extends Controller
{
    public function __construct(
        private ICreateOrderUseCase $createOrderUseCase
    ) {}

    public function store(Request $request)
    {
        $input = new CreateOrderInputData(
            $request->input('status'),
            $request->input('items')
        );

        $output = $this->createOrderUseCase->handle($input);
        return response()->json([
            'id' => $output->id,
            'message' => $output->message
        ]);
    }
}
