<?php
namespace Packages\StoreContext\Store\UseCase\UpdateStoreArea;

class UpdateStoreAreaInputData
{
    public function __construct(
        public readonly string $storeId,
        public readonly string $areaId,
        public readonly bool $isDeliverable
    ) {}
}

