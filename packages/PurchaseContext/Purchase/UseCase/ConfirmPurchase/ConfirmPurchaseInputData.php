<?php
namespace Packages\PurchaseContext\Purchase\UseCase\ConfirmPurchase;

class ConfirmPurchaseInputData
{
    public function __construct(
        public readonly string $orderId
    ) {}
}


