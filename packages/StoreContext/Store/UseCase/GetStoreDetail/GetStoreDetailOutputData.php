<?php
namespace Packages\StoreContext\Store\UseCase\GetStoreDetail;

class GetStoreDetailOutputData
{
    /**
     * @param array<string, mixed> $store
     */
    public function __construct(
        public readonly array $store
    ) {}
}

