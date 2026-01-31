<?php
namespace Packages\StoreContext\Store\Domain;

use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

class StoreBoxLunch
{
    public function __construct(
        public readonly StoreId $storeId,
        public readonly string $boxLunchId,
        public readonly bool $isAvailable
    ) {}

    /**
     * 提供可能にする
     */
    public function makeAvailable(): StoreBoxLunch
    {
        return new StoreBoxLunch(
            $this->storeId,
            $this->boxLunchId,
            true
        );
    }

    /**
     * 提供不可にする
     */
    public function makeUnavailable(): StoreBoxLunch
    {
        return new StoreBoxLunch(
            $this->storeId,
            $this->boxLunchId,
            false
        );
    }
}



