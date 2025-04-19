<?php
namespace Packages\Order\Order\Infrastructure\Eloquent\Repository;

use Packages\Order\Order\Domain\Repository\IOrderRepository;
use Packages\Order\Order\Domain\Entity\Order;
use Packages\Order\Order\Domain\ValueObject\OrderId;
use Packages\Order\Order\Domain\ValueObject\OrderStatus;
use Packages\Order\Order\Domain\ValueObject\OrderItem;
use Packages\Order\Order\Infrastructure\Eloquent\Model\OrderModel;

class IOrderRepository implements IOrderRepository
{
    public function save(Order $order): void
    {
        OrderModel::updateOrCreate(
            ['id' => $order->getId()->getValue()],
            [
                'status' => $order->getStatus()->getValue(),
                'items' => array_map(fn($item) => $item->toArray(), $order->getItems()),
            ]
        );
    }

    public function findById(OrderId $id): ?Order
    {
        $model = OrderModel::find($id->getValue());

        if (!$model) {
            return null;
        }

        $items = array_map(fn($itemData) => OrderItem::fromArray($itemData), $model->items);

        return new Order(
            new OrderId($model->id),
            new OrderStatus($model->status),
            $items
        );
    }

    public function delete(OrderId $id): void
    {
        OrderModel::destroy($id->getValue());
    }

    public function all(): array
    {
        return OrderModel::all()->toArray();
    }
}
