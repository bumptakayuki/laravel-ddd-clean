<?php
namespace Packages\PurchaseContext\Purchase\UseCase\GetPurchase;

class GetPurchaseOutputData
{
    public function __construct(
        public readonly string $purchaseId,
        public readonly string $orderId,
        public readonly string $confirmedAt
    ) {}
}

