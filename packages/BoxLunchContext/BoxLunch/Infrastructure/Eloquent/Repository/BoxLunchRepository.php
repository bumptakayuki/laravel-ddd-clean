<?php
namespace Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Repository;

use Packages\BoxLunchContext\BoxLunch\Domain\BoxLunch;
use Packages\BoxLunchContext\BoxLunch\Domain\BoxLunchOption;
use Packages\BoxLunchContext\BoxLunch\Domain\Repository\BoxLunchRepositoryInterface;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchName;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchPrice;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\OptionId;
use Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model\EloquentBoxLunch;
use Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model\EloquentBoxLunchOption;
use Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model\EloquentStoreBoxLunch;

class BoxLunchRepository implements BoxLunchRepositoryInterface
{
    /**
     * 店舗IDでBox Lunch一覧を取得する
     * 
     * @param string $storeId 店舗ID
     * @return BoxLunch[]
     */
    public function findByStoreId(string $storeId): array
    {
        // store_box_lunchesテーブルから利用可能なbox_lunch_idを取得
        $storeBoxLunchIds = EloquentStoreBoxLunch::where('store_id', $storeId)
            ->where('is_available', true)
            ->pluck('box_lunch_id')
            ->toArray();
        
        if (empty($storeBoxLunchIds)) {
            return [];
        }
        
        $eloquents = EloquentBoxLunch::whereIn('box_lunch_id', $storeBoxLunchIds)
            ->where('is_active', true)
            ->get();
        
        $boxLunches = [];
        foreach ($eloquents as $eloquent) {
            $boxLunches[] = $this->toEntity($eloquent);
        }
        
        return $boxLunches;
    }
    
    /**
     * Box Lunch IDでBox Lunchを取得する（オプション含む）
     * 
     * @param BoxLunchId $boxLunchId 弁当ID
     * @return BoxLunch|null
     */
    public function findByIdWithOptions(BoxLunchId $boxLunchId): ?BoxLunch
    {
        $eloquent = EloquentBoxLunch::with('options')
            ->where('box_lunch_id', $boxLunchId->getValue())
            ->first();
        
        if (!$eloquent) {
            return null;
        }
        
        return $this->toEntityWithOptions($eloquent);
    }
    
    /**
     * Box Lunchを保存する
     * 
     * @param BoxLunch $boxLunch
     * @return void
     */
    public function save(BoxLunch $boxLunch): void
    {
        EloquentBoxLunch::updateOrCreate(
            ['box_lunch_id' => $boxLunch->boxLunchId->getValue()],
            [
                'name' => $boxLunch->name->getValue(),
                'description' => $boxLunch->description,
                'base_price' => $boxLunch->basePrice->getValue(),
                'is_active' => $boxLunch->isActive,
            ]
        );
        
        // オプションも保存
        foreach ($boxLunch->options as $option) {
            EloquentBoxLunchOption::updateOrCreate(
                ['option_id' => $option->optionId->getValue()],
                [
                    'box_lunch_id' => $option->boxLunchId->getValue(),
                    'name' => $option->name,
                    'price_delta' => $option->priceDelta->getValue(),
                    'is_required' => $option->isRequired,
                ]
            );
        }
    }
    
    /**
     * Eloquentモデルをエンティティに変換（オプションなし）
     */
    private function toEntity(EloquentBoxLunch $eloquent): BoxLunch
    {
        return new BoxLunch(
            new BoxLunchId($eloquent->box_lunch_id),
            new BoxLunchName($eloquent->name),
            $eloquent->description,
            new BoxLunchPrice((float)$eloquent->base_price),
            $eloquent->is_active,
            []
        );
    }
    
    /**
     * Eloquentモデルをエンティティに変換（オプション含む）
     */
    private function toEntityWithOptions(EloquentBoxLunch $eloquent): BoxLunch
    {
        $options = [];
        foreach ($eloquent->options as $optionEloquent) {
            $options[] = new BoxLunchOption(
                new OptionId($optionEloquent->option_id),
                new BoxLunchId($optionEloquent->box_lunch_id),
                $optionEloquent->name,
                new BoxLunchPrice((float)$optionEloquent->price_delta),
                $optionEloquent->is_required
            );
        }
        
        return new BoxLunch(
            new BoxLunchId($eloquent->box_lunch_id),
            new BoxLunchName($eloquent->name),
            $eloquent->description,
            new BoxLunchPrice((float)$eloquent->base_price),
            $eloquent->is_active,
            $options
        );
    }
}

