<?php
namespace Packages\OrderContext\Order\UseCase\ListOrders;

class ListOrdersInputData
{
    public function __construct(
        public readonly string $memberId
    ) {}
}

