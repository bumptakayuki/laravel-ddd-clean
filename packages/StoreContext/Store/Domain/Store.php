<?php
namespace Packages\StoreContext\Store\Domain;

use Packages\StoreContext\Store\Domain\ValueObject\StoreId;
use Packages\StoreContext\Store\Domain\ValueObject\StoreName;
use Packages\StoreContext\Store\Domain\ValueObject\StoreAddress;

class Store
{
    public function __construct(
        public readonly StoreId $storeId,
        public readonly StoreName $name,
        public readonly StoreAddress $address,
        public readonly bool $isOpen
    ) {}

    /**
     * 店舗を開店する
     */
    public function open(): Store
    {
        return new Store(
            $this->storeId,
            $this->name,
            $this->address,
            true
        );
    }

    /**
     * 店舗を閉店する
     */
    public function close(): Store
    {
        return new Store(
            $this->storeId,
            $this->name,
            $this->address,
            false
        );
    }
}


