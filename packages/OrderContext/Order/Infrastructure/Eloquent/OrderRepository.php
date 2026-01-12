<?php
namespace Packages\OrderContext\Order\Infrastructure\Eloquent\Repository;

use Packages\OrderContext\Order\Domain\Order;
use Packages\OrderContext\Order\Domain\OrderItem;
use Packages\OrderContext\Order\Domain\Repository\OrderRepositoryInterface;
use Packages\OrderContext\Order\Domain\ValueObject\OrderId;
use Packages\OrderContext\Order\Domain\ValueObject\OrderStatus;
use Packages\OrderContext\Order\Domain\ValueObject\OrderAmount;
use Packages\OrderContext\Order\Domain\ValueObject\OrderItemId;
use Packages\OrderContext\Order\Infrastructure\Eloquent\Model\EloquentOrder;
use Packages\OrderContext\Order\Infrastructure\Eloquent\Model\EloquentOrderItem;

class OrderRepository implements OrderRepositoryInterface
{
    public function save(Order $order): void
    {
        $eloquentOrder = EloquentOrder::updateOrCreate(
            ['order_id' => $order->orderId->getValue()],
            [
                'member_id' => $order->memberId,
                'store_id' => $order->storeId,
                'status' => $order->status->getValue(),
                'total_amount' => $order->totalAmount->getValue(),
                'ordered_at' => $order->orderedAt,
            ]
        );
        
        // 既存の明細を削除
        EloquentOrderItem::where('order_id', $order->orderId->getValue())->delete();
        
        // 新しい明細を保存
        foreach ($order->items as $item) {
            EloquentOrderItem::create([
                'order_item_id' => $item->orderItemId->getValue(),
                'order_id' => $order->orderId->getValue(),
                'configuration_id' => $item->configurationId,
                'unit_price' => $item->unitPrice->getValue(),
                'quantity' => $item->quantity,
                'line_amount' => $item->lineAmount->getValue(),
            ]);
        }
    }
    
    public function findById(OrderId $orderId): ?Order
    {
        $eloquentOrder = EloquentOrder::with('items')
            ->where('order_id', $orderId->getValue())
            ->first();
        
        if (!$eloquentOrder) {
            return null;
        }
        
        return $this->toEntity($eloquentOrder);
    }
    
    public function findByMemberId(string $memberId): array
    {
        $eloquentOrders = EloquentOrder::with('items')
            ->where('member_id', $memberId)
            ->orderBy('ordered_at', 'desc')
            ->get();
        
        $orders = [];
        foreach ($eloquentOrders as $eloquentOrder) {
            $orders[] = $this->toEntity($eloquentOrder);
        }
        
        return $orders;
    }
    
    /**
     * Eloquentモデルをドメインエンティティに変換
     */
    private function toEntity(EloquentOrder $eloquentOrder): Order
    {
        $items = [];
        foreach ($eloquentOrder->items as $eloquentItem) {
            $items[] = new OrderItem(
                new OrderItemId($eloquentItem->order_item_id),
                $eloquentItem->configuration_id,
                new OrderAmount((float)$eloquentItem->unit_price),
                $eloquentItem->quantity,
                new OrderAmount((float)$eloquentItem->line_amount)
            );
        }
        
        return new Order(
            new OrderId($eloquentOrder->order_id),
            $eloquentOrder->member_id,
            $eloquentOrder->store_id,
            new OrderStatus($eloquentOrder->status),
            new OrderAmount((float)$eloquentOrder->total_amount),
            \DateTimeImmutable::createFromMutable($eloquentOrder->ordered_at),
            $items
        );
    }
}

