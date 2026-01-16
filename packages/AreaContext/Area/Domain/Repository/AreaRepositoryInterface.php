<?php
namespace Packages\AreaContext\Area\Domain\Repository;

use Packages\AreaContext\Area\Domain\Area;
use Packages\AreaContext\Area\Domain\ValueObject\AreaId;

interface AreaRepositoryInterface
{
    /**
     * すべてのエリアを取得する
     * 
     * @return Area[]
     */
    public function findAll(): array;
    
    /**
     * エリアIDでエリアを取得する
     * 
     * @param AreaId $areaId エリアID
     * @return Area|null
     */
    public function findById(AreaId $areaId): ?Area;
    
    /**
     * エリアを保存する
     * 
     * @param Area $area
     * @return void
     */
    public function save(Area $area): void;
    
    /**
     * エリアを削除する
     * 
     * @param Area $area
     * @return void
     */
    public function delete(Area $area): void;
}


