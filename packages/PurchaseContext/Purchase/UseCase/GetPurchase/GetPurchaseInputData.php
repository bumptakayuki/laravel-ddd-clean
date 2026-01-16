<?php
namespace Packages\PurchaseContext\Purchase\UseCase\GetPurchase;

class GetPurchaseInputData
{
    public function __construct(
        public readonly string $purchaseId
    ) {}
}


