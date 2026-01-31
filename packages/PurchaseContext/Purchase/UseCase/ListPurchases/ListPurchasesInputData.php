<?php
namespace Packages\PurchaseContext\Purchase\UseCase\ListPurchases;

class ListPurchasesInputData
{
    public function __construct(
        public readonly string $memberId
    ) {}
}



