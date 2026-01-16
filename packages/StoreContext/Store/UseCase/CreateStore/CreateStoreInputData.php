<?php
namespace Packages\StoreContext\Store\UseCase\CreateStore;

class CreateStoreInputData
{
    public function __construct(
        public readonly string $name,
        public readonly string $address,
        public readonly bool $isOpen = true
    ) {}
}


