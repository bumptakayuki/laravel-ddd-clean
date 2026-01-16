<?php
namespace Packages\PurchaseContext\Purchase\Domain\Repository;

use Packages\PurchaseContext\Purchase\Domain\Purchase;
use Packages\PurchaseContext\Purchase\Domain\ValueObject\PurchaseId;

interface PurchaseRepositoryInterface
{
    public function save(Purchase $purchase): void;
    
    public function findById(PurchaseId $purchaseId): ?Purchase;
    
    public function findByOrderId(string $orderId): ?Purchase;
    
    public function findByMemberId(string $memberId): array;
}


