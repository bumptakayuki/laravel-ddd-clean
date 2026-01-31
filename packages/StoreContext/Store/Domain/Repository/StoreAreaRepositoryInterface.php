<?php
namespace Packages\StoreContext\Store\Domain\Repository;

use Packages\StoreContext\Store\Domain\StoreArea;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

interface StoreAreaRepositoryInterface
{
    public function save(StoreArea $storeArea): void;
    
    public function findByStoreId(StoreId $storeId): array;
    
    public function findByStoreIdAndAreaId(StoreId $storeId, string $areaId): ?StoreArea;
    
    public function delete(StoreArea $storeArea): void;
}



