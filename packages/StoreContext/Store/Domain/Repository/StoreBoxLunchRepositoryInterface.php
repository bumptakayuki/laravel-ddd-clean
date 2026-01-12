<?php
namespace Packages\StoreContext\Store\Domain\Repository;

use Packages\StoreContext\Store\Domain\StoreBoxLunch;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

interface StoreBoxLunchRepositoryInterface
{
    public function save(StoreBoxLunch $storeBoxLunch): void;
    
    public function findByStoreId(StoreId $storeId): array;
    
    public function findByStoreIdAndBoxLunchId(StoreId $storeId, string $boxLunchId): ?StoreBoxLunch;
    
    public function delete(StoreBoxLunch $storeBoxLunch): void;
}

