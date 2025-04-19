<?php
namespace Packages\Order\Order\Domain\Repository;

use Packages\Order\Order\Domain\Entity\Order;
use Packages\Order\Order\Domain\ValueObject\OrderId;

interface IOrderRepository
{
    public function save(Order $order): void;
    public function findById(OrderId $id): ?Order;
    public function delete(OrderId $id): void;
    public function all(): array;
}
