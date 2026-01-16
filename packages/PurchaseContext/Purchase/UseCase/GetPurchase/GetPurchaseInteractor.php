<?php
namespace Packages\PurchaseContext\Purchase\UseCase\GetPurchase;

use Packages\PurchaseContext\Purchase\Domain\Repository\PurchaseRepositoryInterface;
use Packages\PurchaseContext\Purchase\Domain\ValueObject\PurchaseId;

class GetPurchaseInteractor implements IGetPurchaseUseCase
{
    public function __construct(
        private readonly PurchaseRepositoryInterface $purchaseRepository
    ) {}
    
    public function handle(GetPurchaseInputData $input): GetPurchaseOutputData
    {
        $purchaseId = new PurchaseId($input->purchaseId);
        $purchase = $this->purchaseRepository->findById($purchaseId);
        
        if (!$purchase) {
            throw new \InvalidArgumentException('購入情報が見つかりません。');
        }
        
        return new GetPurchaseOutputData(
            $purchase->purchaseId->getValue(),
            $purchase->orderId,
            $purchase->confirmedAt->format('Y-m-d H:i:s')
        );
    }
}


