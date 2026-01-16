<?php
namespace Packages\AreaContext\Area\Infrastructure\Eloquent\Repository;

use Packages\AreaContext\Area\Domain\Area;
use Packages\AreaContext\Area\Domain\Repository\AreaRepositoryInterface;
use Packages\AreaContext\Area\Domain\ValueObject\AreaId;
use Packages\AreaContext\Area\Domain\ValueObject\AreaName;
use Packages\AreaContext\Area\Infrastructure\Eloquent\Model\EloquentArea;

class AreaRepository implements AreaRepositoryInterface
{
    /**
     * すべてのエリアを取得する
     * 
     * @return Area[]
     */
    public function findAll(): array
    {
        $eloquents = EloquentArea::all();
        
        $areas = [];
        foreach ($eloquents as $eloquent) {
            $areas[] = $this->toEntity($eloquent);
        }
        
        return $areas;
    }
    
    /**
     * エリアIDでエリアを取得する
     * 
     * @param AreaId $areaId エリアID
     * @return Area|null
     */
    public function findById(AreaId $areaId): ?Area
    {
        $eloquent = EloquentArea::where('area_id', $areaId->getValue())->first();
        
        if (!$eloquent) {
            return null;
        }
        
        return $this->toEntity($eloquent);
    }
    
    /**
     * エリアを保存する
     * 
     * @param Area $area
     * @return void
     */
    public function save(Area $area): void
    {
        EloquentArea::updateOrCreate(
            ['area_id' => $area->areaId->getValue()],
            [
                'name' => $area->name->getValue(),
            ]
        );
    }
    
    /**
     * エリアを削除する
     * 
     * @param Area $area
     * @return void
     */
    public function delete(Area $area): void
    {
        EloquentArea::where('area_id', $area->areaId->getValue())->delete();
    }
    
    /**
     * Eloquentモデルをエンティティに変換
     */
    private function toEntity(EloquentArea $eloquent): Area
    {
        return new Area(
            new AreaId($eloquent->area_id),
            new AreaName($eloquent->name)
        );
    }
}


