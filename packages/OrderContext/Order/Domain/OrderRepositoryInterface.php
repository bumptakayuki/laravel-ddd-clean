<?php
namespace Packages\OrderContext\Order\Domain\Repository;

use Packages\OrderContext\Order\Domain\Entity\Order;
use Packages\OrderContext\Order\Domain\ValueObject\OrderId;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;
    
    public function findById(OrderId $orderId): ?Order;
    
    public function findByMemberId(string $memberId): array;
}


