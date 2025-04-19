<?php
namespace Packages\Order\Order\UseCase\CreateOrder;

class CreateOrderInputData
{
    public function __construct(
        public readonly string $status,
        public readonly array $items
    ) {}
}
