<?php
namespace Packages\Order\Order\Domain\Entity;

use Packages\Order\Order\Domain\ValueObject\OrderId;
use Packages\Order\Order\Domain\ValueObject\OrderStatus;
use Packages\Order\Order\Domain\ValueObject\OrderItem;

class Order
{
    private OrderId $id;
    private OrderStatus $status;
    private array $items;

    public function __construct(OrderId $id, OrderStatus $status, array $items)
    {
        $this->id = $id;
        $this->status = $status;
        $this->items = $items;
    }

    public function getId(): OrderId
    {
        return $this->id;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function updateStatus(OrderStatus $status): void
    {
        $this->status = $status;
    }

    public function updateItems(array $items): void
    {
        $this->items = $items;
    }
}
