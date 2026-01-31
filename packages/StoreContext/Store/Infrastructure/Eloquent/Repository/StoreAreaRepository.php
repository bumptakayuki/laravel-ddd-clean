<?php
namespace Packages\StoreContext\Store\Infrastructure\Eloquent\Repository;

use Packages\StoreContext\Store\Domain\StoreArea;
use Packages\StoreContext\Store\Domain\Repository\StoreAreaRepositoryInterface;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;
use Packages\StoreContext\Store\Infrastructure\Eloquent\Model\EloquentStoreArea;

class StoreAreaRepository implements StoreAreaRepositoryInterface
{
    public function save(StoreArea $storeArea): void
    {
        EloquentStoreArea::updateOrCreate(
            [
                'store_id' => $storeArea->storeId->getValue(),
                'area_id' => $storeArea->areaId,
            ],
            [
                'is_deliverable' => $storeArea->isDeliverable,
            ]
        );
    }
    
    public function findByStoreId(StoreId $storeId): array
    {
        $eloquentStoreAreas = EloquentStoreArea::where('store_id', $storeId->getValue())->get();
        
        $storeAreas = [];
        foreach ($eloquentStoreAreas as $eloquentStoreArea) {
            $storeAreas[] = $this->toEntity($eloquentStoreArea);
        }
        
        return $storeAreas;
    }
    
    public function findByStoreIdAndAreaId(StoreId $storeId, string $areaId): ?StoreArea
    {
        $eloquentStoreArea = EloquentStoreArea::where('store_id', $storeId->getValue())
            ->where('area_id', $areaId)
            ->first();
        
        if (!$eloquentStoreArea) {
            return null;
        }
        
        return $this->toEntity($eloquentStoreArea);
    }
    
    public function delete(StoreArea $storeArea): void
    {
        EloquentStoreArea::where('store_id', $storeArea->storeId->getValue())
            ->where('area_id', $storeArea->areaId)
            ->delete();
    }
    
    /**
     * Eloquentモデルをドメインエンティティに変換
     */
    private function toEntity(EloquentStoreArea $eloquentStoreArea): StoreArea
    {
        return new StoreArea(
            new StoreId($eloquentStoreArea->store_id),
            $eloquentStoreArea->area_id,
            $eloquentStoreArea->is_deliverable
        );
    }
}



