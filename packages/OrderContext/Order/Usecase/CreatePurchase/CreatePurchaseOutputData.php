<?php
namespace Packages\OrderContext\Order\UseCase\CreatePurchase;

class CreatePurchaseOutputData
{
    public function __construct(
        public readonly string $purchaseId,
        public readonly string $message
    ) {}
}

