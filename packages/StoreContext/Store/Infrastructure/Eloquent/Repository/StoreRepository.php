<?php
namespace Packages\StoreContext\Store\Infrastructure\Eloquent\Repository;

use Packages\StoreContext\Store\Domain\Store;
use Packages\StoreContext\Store\Domain\Repository\StoreRepositoryInterface;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;
use Packages\StoreContext\Store\Domain\ValueObject\StoreName;
use Packages\StoreContext\Store\Domain\ValueObject\StoreAddress;
use Packages\StoreContext\Store\Infrastructure\Eloquent\Model\EloquentStore;

class StoreRepository implements StoreRepositoryInterface
{
    public function save(Store $store): void
    {
        EloquentStore::updateOrCreate(
            ['store_id' => $store->storeId->getValue()],
            [
                'name' => $store->name->getValue(),
                'address' => $store->address->getValue(),
                'is_open' => $store->isOpen,
            ]
        );
    }
    
    public function findById(StoreId $storeId): ?Store
    {
        $eloquentStore = EloquentStore::where('store_id', $storeId->getValue())->first();
        
        if (!$eloquentStore) {
            return null;
        }
        
        return $this->toEntity($eloquentStore);
    }
    
    public function findAll(): array
    {
        $eloquentStores = EloquentStore::orderBy('name')->get();
        
        $stores = [];
        foreach ($eloquentStores as $eloquentStore) {
            $stores[] = $this->toEntity($eloquentStore);
        }
        
        return $stores;
    }
    
    public function delete(Store $store): void
    {
        EloquentStore::where('store_id', $store->storeId->getValue())->delete();
    }
    
    /**
     * Eloquentモデルをドメインエンティティに変換
     */
    private function toEntity(EloquentStore $eloquentStore): Store
    {
        return new Store(
            new StoreId($eloquentStore->store_id),
            new StoreName($eloquentStore->name),
            new StoreAddress($eloquentStore->address),
            $eloquentStore->is_open
        );
    }
}


