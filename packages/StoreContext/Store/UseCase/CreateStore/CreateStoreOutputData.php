<?php
namespace Packages\StoreContext\Store\UseCase\CreateStore;

class CreateStoreOutputData
{
    public function __construct(
        public readonly string $storeId,
        public readonly string $message
    ) {}
}


