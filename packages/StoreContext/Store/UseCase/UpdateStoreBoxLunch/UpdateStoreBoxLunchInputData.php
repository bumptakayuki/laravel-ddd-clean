<?php
namespace Packages\StoreContext\Store\UseCase\UpdateStoreBoxLunch;

class UpdateStoreBoxLunchInputData
{
    public function __construct(
        public readonly string $storeId,
        public readonly string $boxLunchId,
        public readonly bool $isAvailable
    ) {}
}


