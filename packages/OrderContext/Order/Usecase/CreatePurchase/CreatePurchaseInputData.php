<?php
namespace Packages\OrderContext\Order\UseCase\CreatePurchase;

class CreatePurchaseInputData
{
    public function __construct(
        public readonly string $orderId
    ) {}
}

