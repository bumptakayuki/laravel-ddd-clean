<?php
namespace Packages\StoreContext\Store\UseCase\CreateStoreArea;

class CreateStoreAreaInputData
{
    public function __construct(
        public readonly string $storeId,
        public readonly string $areaId,
        public readonly bool $isDeliverable = true
    ) {}
}

