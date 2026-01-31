<?php
namespace Packages\PurchaseContext\Purchase\UseCase\ConfirmPurchase;

interface IConfirmPurchaseUseCase
{
    public function handle(ConfirmPurchaseInputData $input): ConfirmPurchaseOutputData;
}



