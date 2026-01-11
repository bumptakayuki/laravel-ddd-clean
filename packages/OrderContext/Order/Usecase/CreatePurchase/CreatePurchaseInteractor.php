<?php
namespace Packages\OrderContext\Order\UseCase\CreatePurchase;

use Packages\OrderContext\Order\Domain\Repository\OrderRepositoryInterface;
use Packages\OrderContext\Order\Domain\ValueObject\OrderId;
use Packages\OrderContext\Order\Domain\ValueObject\OrderStatus;
use Packages\OrderContext\Order\Infrastructure\Eloquent\Model\EloquentPurchase;
use Illuminate\Support\Str;

class CreatePurchaseInteractor implements ICreatePurchaseUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {}
    
    public function handle(CreatePurchaseInputData $input): CreatePurchaseOutputData
    {
        $orderId = new OrderId($input->orderId);
        $order = $this->orderRepository->findById($orderId);
        
        if (!$order) {
            throw new \InvalidArgumentException('注文が見つかりません。');
        }
        
        // 購入レコードを作成
        $purchaseId = Str::uuid()->toString();
        EloquentPurchase::create([
            'purchase_id' => $purchaseId,
            'order_id' => $input->orderId,
            'confirmed_at' => now(),
        ]);
        
        // 注文の状態を更新（準備完了）
        $updatedOrder = new \Packages\OrderContext\Order\Domain\Order(
            $order->orderId,
            $order->memberId,
            $order->storeId,
            new OrderStatus(OrderStatus::READY),
            $order->totalAmount,
            $order->orderedAt,
            $order->items
        );
        
        $this->orderRepository->save($updatedOrder);
        
        return new CreatePurchaseOutputData(
            $purchaseId,
            '購入が確定しました。'
        );
    }
}

