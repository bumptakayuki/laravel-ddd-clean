<?php
namespace Packages\StoreContext\Store\Domain\Repository;

use Packages\StoreContext\Store\Domain\Store;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

interface StoreRepositoryInterface
{
    public function save(Store $store): void;
    
    public function findById(StoreId $storeId): ?Store;
    
    public function findAll(): array;
    
    public function delete(Store $store): void;
}



