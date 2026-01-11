<?php
namespace Packages\OrderContext\Order\UseCase\CreateAcceptance;

use Packages\OrderContext\Order\Domain\Repository\OrderRepositoryInterface;
use Packages\OrderContext\Order\Domain\ValueObject\OrderId;
use Packages\OrderContext\Order\Domain\ValueObject\OrderStatus;
use Packages\OrderContext\Order\Infrastructure\Eloquent\Model\EloquentAcceptance;
use Illuminate\Support\Str;

class CreateAcceptanceInteractor implements ICreateAcceptanceUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {}
    
    public function handle(CreateAcceptanceInputData $input): CreateAcceptanceOutputData
    {
        $orderId = new OrderId($input->orderId);
        $order = $this->orderRepository->findById($orderId);
        
        if (!$order) {
            throw new \InvalidArgumentException('注文が見つかりません。');
        }
        
        // 受注レコードを作成
        $acceptanceId = Str::uuid()->toString();
        EloquentAcceptance::create([
            'acceptance_id' => $acceptanceId,
            'order_id' => $input->orderId,
            'accepted_at' => now(),
        ]);
        
        // 注文の状態を更新（準備中）
        $updatedOrder = new \Packages\OrderContext\Order\Domain\Order(
            $order->orderId,
            $order->memberId,
            $order->storeId,
            new OrderStatus(OrderStatus::PREPARING),
            $order->totalAmount,
            $order->orderedAt,
            $order->items
        );
        
        $this->orderRepository->save($updatedOrder);
        
        return new CreateAcceptanceOutputData(
            $acceptanceId,
            '注文が受注されました。'
        );
    }
}

