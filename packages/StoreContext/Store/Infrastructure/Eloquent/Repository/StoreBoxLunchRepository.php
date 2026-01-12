<?php
namespace Packages\StoreContext\Store\Infrastructure\Eloquent\Repository;

use Packages\StoreContext\Store\Domain\StoreBoxLunch;
use Packages\StoreContext\Store\Domain\Repository\StoreBoxLunchRepositoryInterface;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;
use Packages\StoreContext\Store\Infrastructure\Eloquent\Model\EloquentStoreBoxLunch;

class StoreBoxLunchRepository implements StoreBoxLunchRepositoryInterface
{
    public function save(StoreBoxLunch $storeBoxLunch): void
    {
        EloquentStoreBoxLunch::updateOrCreate(
            [
                'store_id' => $storeBoxLunch->storeId->getValue(),
                'box_lunch_id' => $storeBoxLunch->boxLunchId,
            ],
            [
                'is_available' => $storeBoxLunch->isAvailable,
            ]
        );
    }
    
    public function findByStoreId(StoreId $storeId): array
    {
        $eloquentStoreBoxLunches = EloquentStoreBoxLunch::where('store_id', $storeId->getValue())->get();
        
        $storeBoxLunches = [];
        foreach ($eloquentStoreBoxLunches as $eloquentStoreBoxLunch) {
            $storeBoxLunches[] = $this->toEntity($eloquentStoreBoxLunch);
        }
        
        return $storeBoxLunches;
    }
    
    public function findByStoreIdAndBoxLunchId(StoreId $storeId, string $boxLunchId): ?StoreBoxLunch
    {
        $eloquentStoreBoxLunch = EloquentStoreBoxLunch::where('store_id', $storeId->getValue())
            ->where('box_lunch_id', $boxLunchId)
            ->first();
        
        if (!$eloquentStoreBoxLunch) {
            return null;
        }
        
        return $this->toEntity($eloquentStoreBoxLunch);
    }
    
    public function delete(StoreBoxLunch $storeBoxLunch): void
    {
        EloquentStoreBoxLunch::where('store_id', $storeBoxLunch->storeId->getValue())
            ->where('box_lunch_id', $storeBoxLunch->boxLunchId)
            ->delete();
    }
    
    /**
     * Eloquentモデルをドメインエンティティに変換
     */
    private function toEntity(EloquentStoreBoxLunch $eloquentStoreBoxLunch): StoreBoxLunch
    {
        return new StoreBoxLunch(
            new StoreId($eloquentStoreBoxLunch->store_id),
            $eloquentStoreBoxLunch->box_lunch_id,
            $eloquentStoreBoxLunch->is_available
        );
    }
}

