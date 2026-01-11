<?php
namespace Packages\OrderContext\Order\Domain;

use Packages\OrderContext\Order\Domain\ValueObject\OrderId;
use Packages\OrderContext\Order\Domain\ValueObject\OrderStatus;
use Packages\OrderContext\Order\Domain\ValueObject\OrderAmount;

class Order
{
    /**
     * @param OrderItem[] $items
     */
    public function __construct(
        public readonly OrderId $orderId,
        public readonly string $memberId,
        public readonly string $storeId,
        public readonly OrderStatus $status,
        public readonly OrderAmount $totalAmount,
        public readonly \DateTimeImmutable $orderedAt,
        public readonly array $items = []
    ) {}

    /**
     * 注文に明細を追加する
     */
    public function addItem(OrderItem $item): Order
    {
        $items = $this->items;
        $items[] = $item;
        
        $newTotalAmount = $this->calculateTotalAmount($items);
        
        return new Order(
            $this->orderId,
            $this->memberId,
            $this->storeId,
            $this->status,
            $newTotalAmount,
            $this->orderedAt,
            $items
        );
    }

    /**
     * 合計金額を計算する
     * 
     * @param OrderItem[] $items
     */
    private function calculateTotalAmount(array $items): OrderAmount
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item->lineAmount->getValue();
        }
        
        return new OrderAmount($total);
    }
}

