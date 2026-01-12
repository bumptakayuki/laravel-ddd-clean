<?php
namespace Packages\StoreContext\Store\UseCase\UpdateStore;

class UpdateStoreInputData
{
    public function __construct(
        public readonly string $storeId,
        public readonly ?string $name = null,
        public readonly ?string $address = null,
        public readonly ?bool $isOpen = null
    ) {}
}

