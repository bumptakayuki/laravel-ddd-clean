<?php
namespace Packages\PurchaseContext\Purchase\UseCase\ListPurchases;

use Packages\PurchaseContext\Purchase\Domain\Repository\PurchaseRepositoryInterface;

class ListPurchasesInteractor implements IListPurchasesUseCase
{
    public function __construct(
        private readonly PurchaseRepositoryInterface $purchaseRepository
    ) {}
    
    public function handle(ListPurchasesInputData $input): ListPurchasesOutputData
    {
        $purchases = $this->purchaseRepository->findByMemberId($input->memberId);
        
        $purchaseData = [];
        foreach ($purchases as $purchase) {
            $purchaseData[] = [
                'purchaseId' => $purchase->purchaseId->getValue(),
                'orderId' => $purchase->orderId,
                'confirmedAt' => $purchase->confirmedAt->format('Y-m-d H:i:s'),
            ];
        }
        
        return new ListPurchasesOutputData($purchaseData);
    }
}

