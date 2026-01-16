<?php
namespace Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Repository;

use Packages\BoxLunchContext\BoxLunch\Domain\BoxLunchConfiguration;
use Packages\BoxLunchContext\BoxLunch\Domain\OptionSelection;
use Packages\BoxLunchContext\BoxLunch\Domain\Repository\BoxLunchConfigurationRepositoryInterface;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\ConfigurationId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\AvailabilityStatus;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchPrice;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\OptionId;
use Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model\EloquentBoxLunchConfiguration;
use Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model\EloquentOptionSelection;

class BoxLunchConfigurationRepository implements BoxLunchConfigurationRepositoryInterface
{
    /**
     * Box Lunch構成を保存する
     * 
     * @param BoxLunchConfiguration $configuration
     * @return void
     */
    public function save(BoxLunchConfiguration $configuration): void
    {
        EloquentBoxLunchConfiguration::updateOrCreate(
            ['configuration_id' => $configuration->configurationId->getValue()],
            [
                'box_lunch_id' => $configuration->boxLunchId->getValue(),
                'availability_status' => $configuration->availabilityStatus->getValue(),
                'total_price' => $configuration->totalPrice->getValue(),
            ]
        );
        
        // 既存の選択を削除
        EloquentOptionSelection::where('configuration_id', $configuration->configurationId->getValue())
            ->delete();
        
        // 選択を保存
        foreach ($configuration->selections as $selection) {
            EloquentOptionSelection::create([
                'selection_id' => $selection->selectionId,
                'configuration_id' => $selection->configurationId->getValue(),
                'option_id' => $selection->optionId->getValue(),
                'quantity' => $selection->quantity,
            ]);
        }
    }
    
    /**
     * 構成IDでBox Lunch構成を取得する
     * 
     * @param ConfigurationId $configurationId
     * @return BoxLunchConfiguration|null
     */
    public function findById(ConfigurationId $configurationId): ?BoxLunchConfiguration
    {
        $eloquent = EloquentBoxLunchConfiguration::with('selections')
            ->where('configuration_id', $configurationId->getValue())
            ->first();
        
        if (!$eloquent) {
            return null;
        }
        
        return $this->toEntity($eloquent);
    }
    
    /**
     * Eloquentモデルをエンティティに変換
     */
    private function toEntity(EloquentBoxLunchConfiguration $eloquent): BoxLunchConfiguration
    {
        $selections = [];
        foreach ($eloquent->selections as $selectionEloquent) {
            $selections[] = new OptionSelection(
                $selectionEloquent->selection_id,
                new ConfigurationId($selectionEloquent->configuration_id),
                new OptionId($selectionEloquent->option_id),
                $selectionEloquent->quantity
            );
        }
        
        return new BoxLunchConfiguration(
            new ConfigurationId($eloquent->configuration_id),
            new BoxLunchId($eloquent->box_lunch_id),
            new AvailabilityStatus($eloquent->availability_status),
            new BoxLunchPrice((float)$eloquent->total_price),
            $selections
        );
    }
}


