<?php
namespace Packages\PurchaseContext\Purchase\UseCase\ConfirmPurchase;

class ConfirmPurchaseOutputData
{
    public function __construct(
        public readonly string $purchaseId,
        public readonly string $message
    ) {}
}



