<?php
namespace Packages\PurchaseContext\Purchase\UseCase\GetPurchase;

interface IGetPurchaseUseCase
{
    public function handle(GetPurchaseInputData $input): GetPurchaseOutputData;
}



