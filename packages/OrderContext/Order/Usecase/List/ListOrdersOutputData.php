<?php
namespace Packages\OrderContext\Order\UseCase\ListOrders;

class ListOrdersOutputData
{
    /**
     * @param array[] $orders
     */
    public function __construct(
        public readonly array $orders
    ) {}
}

