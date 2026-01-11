<?php
namespace Packages\OrderContext\Order\UseCase\CreateOrder;

class CreateOrderItemInputData
{
    public function __construct(
        public readonly string $configurationId,
        public readonly float $unitPrice,
        public readonly int $quantity
    ) {}
}

