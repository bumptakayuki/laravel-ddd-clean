<?php
namespace Packages\PurchaseContext\Purchase\Infrastructure\Eloquent\Repository;

use Packages\PurchaseContext\Purchase\Domain\Purchase;
use Packages\PurchaseContext\Purchase\Domain\Repository\PurchaseRepositoryInterface;
use Packages\PurchaseContext\Purchase\Domain\ValueObject\PurchaseId;
use Packages\PurchaseContext\Purchase\Infrastructure\Eloquent\Model\EloquentPurchase;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function save(Purchase $purchase): void
    {
        EloquentPurchase::updateOrCreate(
            ['purchase_id' => $purchase->purchaseId->getValue()],
            [
                'order_id' => $purchase->orderId,
                'confirmed_at' => $purchase->confirmedAt,
            ]
        );
    }
    
    public function findById(PurchaseId $purchaseId): ?Purchase
    {
        $eloquentPurchase = EloquentPurchase::where('purchase_id', $purchaseId->getValue())->first();
        
        if (!$eloquentPurchase) {
            return null;
        }
        
        return $this->toEntity($eloquentPurchase);
    }
    
    public function findByOrderId(string $orderId): ?Purchase
    {
        $eloquentPurchase = EloquentPurchase::where('order_id', $orderId)->first();
        
        if (!$eloquentPurchase) {
            return null;
        }
        
        return $this->toEntity($eloquentPurchase);
    }
    
    public function findByMemberId(string $memberId): array
    {
        // Orderテーブルと結合してmember_idで検索
        $eloquentPurchases = EloquentPurchase::join('orders', 'purchases.order_id', '=', 'orders.order_id')
            ->where('orders.member_id', $memberId)
            ->select('purchases.*')
            ->orderBy('purchases.confirmed_at', 'desc')
            ->get();
        
        $purchases = [];
        foreach ($eloquentPurchases as $eloquentPurchase) {
            $purchases[] = $this->toEntity($eloquentPurchase);
        }
        
        return $purchases;
    }
    
    /**
     * Eloquentモデルをドメインエンティティに変換
     */
    private function toEntity(EloquentPurchase $eloquentPurchase): Purchase
    {
        return new Purchase(
            new PurchaseId($eloquentPurchase->purchase_id),
            $eloquentPurchase->order_id,
            \DateTimeImmutable::createFromMutable($eloquentPurchase->confirmed_at)
        );
    }
}

