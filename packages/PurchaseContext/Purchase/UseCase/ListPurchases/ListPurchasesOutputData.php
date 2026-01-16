<?php
namespace Packages\PurchaseContext\Purchase\UseCase\ListPurchases;

class ListPurchasesOutputData
{
    /**
     * @param array<array{purchaseId: string, orderId: string, confirmedAt: string}> $purchases
     */
    public function __construct(
        public readonly array $purchases
    ) {}
}


