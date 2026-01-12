<?php
namespace Packages\StoreContext\Store\Domain;

use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

class StoreArea
{
    public function __construct(
        public readonly StoreId $storeId,
        public readonly string $areaId,
        public readonly bool $isDeliverable
    ) {}

    /**
     * 配達可能にする
     */
    public function makeDeliverable(): StoreArea
    {
        return new StoreArea(
            $this->storeId,
            $this->areaId,
            true
        );
    }

    /**
     * 配達不可にする
     */
    public function makeUndeliverable(): StoreArea
    {
        return new StoreArea(
            $this->storeId,
            $this->areaId,
            false
        );
    }
}

