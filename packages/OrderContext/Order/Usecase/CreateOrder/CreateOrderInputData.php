<?php
namespace Packages\OrderContext\Order\UseCase\CreateOrder;

class CreateOrderInputData
{
    /**
     * @param CreateOrderItemInputData[] $items
     */
    public function __construct(
        public readonly string $memberId,
        public readonly string $storeId,
        public readonly array $items
    ) {}
}

