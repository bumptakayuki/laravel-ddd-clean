<?php
namespace Packages\PurchaseContext\Purchase\Domain;

use Packages\PurchaseContext\Purchase\Domain\ValueObject\PurchaseId;

class Purchase
{
    public function __construct(
        public readonly PurchaseId $purchaseId,
        public readonly string $orderId,
        public readonly \DateTimeImmutable $confirmedAt
    ) {}
}


