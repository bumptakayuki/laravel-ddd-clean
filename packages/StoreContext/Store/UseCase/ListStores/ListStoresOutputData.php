<?php
namespace Packages\StoreContext\Store\UseCase\ListStores;

class ListStoresOutputData
{
    /**
     * @param array<string, mixed> $stores
     */
    public function __construct(
        public readonly array $stores
    ) {}
}


