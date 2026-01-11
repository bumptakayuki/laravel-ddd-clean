<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain\Repository;

use Packages\BoxLunchContext\BoxLunch\Domain\BoxLunch;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchId;

interface BoxLunchRepositoryInterface
{
    /**
     * 店舗IDでBox Lunch一覧を取得する
     * 
     * @param string $storeId 店舗ID
     * @return BoxLunch[]
     */
    public function findByStoreId(string $storeId): array;
    
    /**
     * Box Lunch IDでBox Lunchを取得する（オプション含む）
     * 
     * @param BoxLunchId $boxLunchId 弁当ID
     * @return BoxLunch|null
     */
    public function findByIdWithOptions(BoxLunchId $boxLunchId): ?BoxLunch;
    
    /**
     * Box Lunchを保存する
     * 
     * @param BoxLunch $boxLunch
     * @return void
     */
    public function save(BoxLunch $boxLunch): void;
}

