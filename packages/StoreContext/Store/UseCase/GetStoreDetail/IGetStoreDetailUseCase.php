<?php
namespace Packages\StoreContext\Store\UseCase\GetStoreDetail;

interface IGetStoreDetailUseCase
{
    public function handle(GetStoreDetailInputData $input): GetStoreDetailOutputData;
}

