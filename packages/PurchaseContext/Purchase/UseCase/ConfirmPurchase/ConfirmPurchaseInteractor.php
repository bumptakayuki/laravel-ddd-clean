<?php
namespace Packages\PurchaseContext\Purchase\UseCase\ConfirmPurchase;

use Packages\PurchaseContext\Purchase\Domain\Purchase;
use Packages\PurchaseContext\Purchase\Domain\Repository\PurchaseRepositoryInterface;
use Packages\PurchaseContext\Purchase\Domain\ValueObject\PurchaseId;
use Illuminate\Support\Str;

class ConfirmPurchaseInteractor implements IConfirmPurchaseUseCase
{
    public function __construct(
        private readonly PurchaseRepositoryInterface $purchaseRepository
    ) {}
    
    public function handle(ConfirmPurchaseInputData $input): ConfirmPurchaseOutputData
    {
        // 既存の購入レコードを確認
        $existingPurchase = $this->purchaseRepository->findByOrderId($input->orderId);
        
        if ($existingPurchase) {
            throw new \InvalidArgumentException('この注文は既に購入確定されています。');
        }
        
        // 購入レコードを作成
        $purchaseId = new PurchaseId(Str::uuid()->toString());
        $confirmedAt = new \DateTimeImmutable();
        
        $purchase = new Purchase(
            $purchaseId,
            $input->orderId,
            $confirmedAt
        );
        
        $this->purchaseRepository->save($purchase);
        
        return new ConfirmPurchaseOutputData(
            $purchaseId->getValue(),
            '購入が確定しました。'
        );
    }
}



