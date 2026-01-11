<?php
namespace Packages\OrderContext\Order\UseCase\CreatePurchase;

interface ICreatePurchaseUseCase
{
    public function handle(CreatePurchaseInputData $input): CreatePurchaseOutputData;
}

