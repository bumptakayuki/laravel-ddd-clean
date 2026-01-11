<?php
namespace Packages\OrderContext\Order\UseCase\CreateOrder;

use Packages\OrderContext\Order\Domain\Order;
use Packages\OrderContext\Order\Domain\OrderItem;
use Packages\OrderContext\Order\Domain\Repository\OrderRepositoryInterface;
use Packages\OrderContext\Order\Domain\ValueObject\OrderId;
use Packages\OrderContext\Order\Domain\ValueObject\OrderStatus;
use Packages\OrderContext\Order\Domain\ValueObject\OrderAmount;
use Packages\OrderContext\Order\Domain\ValueObject\OrderItemId;
use Illuminate\Support\Str;

class CreateOrderInteractor implements ICreateOrderUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {}
    
    public function handle(CreateOrderInputData $input): CreateOrderOutputData
    {
        $orderId = new OrderId(Str::uuid()->toString());
        $status = new OrderStatus(OrderStatus::PENDING);
        $orderedAt = new \DateTimeImmutable();
        
        $order = new Order(
            $orderId,
            $input->memberId,
            $input->storeId,
            $status,
            new OrderAmount(0),
            $orderedAt,
            []
        );
        
        // 明細を追加
        foreach ($input->items as $itemInput) {
            $orderItemId = new OrderItemId(Str::uuid()->toString());
            $unitPrice = new OrderAmount($itemInput->unitPrice);
            $lineAmount = new OrderAmount($itemInput->unitPrice * $itemInput->quantity);
            
            $orderItem = new OrderItem(
                $orderItemId,
                $itemInput->configurationId,
                $unitPrice,
                $itemInput->quantity,
                $lineAmount
            );
            
            $order = $order->addItem($orderItem);
        }
        
        $this->orderRepository->save($order);
        
        return new CreateOrderOutputData(
            $orderId->getValue(),
            '注文が作成されました。'
        );
    }
}

