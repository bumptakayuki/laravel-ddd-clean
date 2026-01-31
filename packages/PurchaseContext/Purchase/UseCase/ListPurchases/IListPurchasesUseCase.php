<?php
namespace Packages\PurchaseContext\Purchase\UseCase\ListPurchases;

interface IListPurchasesUseCase
{
    public function handle(ListPurchasesInputData $input): ListPurchasesOutputData;
}



