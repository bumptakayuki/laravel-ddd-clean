<?php
namespace Packages\OrderContext\Order\UseCase\CreateOrder;

class CreateOrderOutputData
{
    public function __construct(
        public readonly string $orderId,
        public readonly string $message
    ) {}
}

