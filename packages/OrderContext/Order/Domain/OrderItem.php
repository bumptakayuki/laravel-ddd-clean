<?php
namespace Packages\OrderContext\Order\Domain;

use Packages\OrderContext\Order\Domain\ValueObject\OrderItemId;
use Packages\OrderContext\Order\Domain\ValueObject\OrderAmount;

class OrderItem
{
    public function __construct(
        public readonly OrderItemId $orderItemId,
        public readonly string $configurationId,
        public readonly OrderAmount $unitPrice,
        public readonly int $quantity,
        public readonly OrderAmount $lineAmount
    ) {}
}

