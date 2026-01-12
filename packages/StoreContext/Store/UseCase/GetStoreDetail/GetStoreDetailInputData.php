<?php
namespace Packages\StoreContext\Store\UseCase\GetStoreDetail;

class GetStoreDetailInputData
{
    public function __construct(
        public readonly string $storeId
    ) {}
}

