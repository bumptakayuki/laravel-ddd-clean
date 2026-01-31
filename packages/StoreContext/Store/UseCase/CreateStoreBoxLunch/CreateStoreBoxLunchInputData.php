<?php
namespace Packages\StoreContext\Store\UseCase\CreateStoreBoxLunch;

class CreateStoreBoxLunchInputData
{
    public function __construct(
        public readonly string $storeId,
        public readonly string $boxLunchId,
        public readonly bool $isAvailable = true
    ) {}
}



