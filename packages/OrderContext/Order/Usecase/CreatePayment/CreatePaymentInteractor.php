<?php
namespace Packages\OrderContext\Order\UseCase\CreatePayment;

use Packages\OrderContext\Order\Domain\Repository\OrderRepositoryInterface;
use Packages\OrderContext\Order\Domain\ValueObject\OrderId;
use Packages\OrderContext\Order\Domain\ValueObject\OrderStatus;
use Packages\OrderContext\Order\Infrastructure\Eloquent\Model\EloquentPayment;
use Illuminate\Support\Str;

class CreatePaymentInteractor implements ICreatePaymentUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {}
    
    public function handle(CreatePaymentInputData $input): CreatePaymentOutputData
    {
        $orderId = new OrderId($input->orderId);
        $order = $this->orderRepository->findById($orderId);
        
        if (!$order) {
            throw new \InvalidArgumentException('注文が見つかりません。');
        }
        
        // 決済レコードを作成
        $paymentId = Str::uuid()->toString();
        EloquentPayment::create([
            'payment_id' => $paymentId,
            'order_id' => $input->orderId,
            'method' => $input->method,
            'status' => 'completed',
            'transaction_id' => $input->transactionId,
            'paid_at' => now(),
        ]);
        
        // 注文の状態を更新（決済済み）
        $updatedOrder = new \Packages\OrderContext\Order\Domain\Order(
            $order->orderId,
            $order->memberId,
            $order->storeId,
            new OrderStatus(OrderStatus::CONFIRMED),
            $order->totalAmount,
            $order->orderedAt,
            $order->items
        );
        
        $this->orderRepository->save($updatedOrder);
        
        return new CreatePaymentOutputData(
            $paymentId,
            '決済が完了しました。'
        );
    }
}

