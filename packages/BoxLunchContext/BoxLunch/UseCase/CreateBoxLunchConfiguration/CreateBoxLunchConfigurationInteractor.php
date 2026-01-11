<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration;

use Packages\BoxLunchContext\BoxLunch\Domain\BoxLunchConfiguration;
use Packages\BoxLunchContext\BoxLunch\Domain\OptionSelection;
use Packages\BoxLunchContext\BoxLunch\Domain\Repository\BoxLunchConfigurationRepositoryInterface;
use Packages\BoxLunchContext\BoxLunch\Domain\Repository\BoxLunchRepositoryInterface;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\ConfigurationId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\AvailabilityStatus;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchPrice;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\OptionId;
use Illuminate\Support\Str;

class CreateBoxLunchConfigurationInteractor implements ICreateBoxLunchConfigurationUseCase
{
    public function __construct(
        private readonly BoxLunchConfigurationRepositoryInterface $configurationRepository,
        private readonly BoxLunchRepositoryInterface $boxLunchRepository
    ) {}
    
    public function handle(CreateBoxLunchConfigurationInputData $input): CreateBoxLunchConfigurationOutputData
    {
        // Box Lunchを取得して基本価格を取得
        $boxLunchId = new BoxLunchId($input->boxLunchId);
        $boxLunch = $this->boxLunchRepository->findByIdWithOptions($boxLunchId);
        
        if ($boxLunch === null) {
            throw new \RuntimeException('指定されたBox Lunchが見つかりません。');
        }
        
        // 構成IDを生成（全選択で共通）
        $configurationId = new ConfigurationId(Str::uuid()->toString());
        
        // 合計価格を計算
        $totalPrice = $boxLunch->basePrice->getValue();
        $selections = [];
        
        foreach ($input->selections as $selectionInput) {
            // オプションを検証
            $optionId = new OptionId($selectionInput->optionId);
            $option = null;
            foreach ($boxLunch->options as $opt) {
                if ($opt->optionId->getValue() === $optionId->getValue()) {
                    $option = $opt;
                    break;
                }
            }
            
            if ($option === null) {
                throw new \RuntimeException('指定されたオプションが見つかりません。');
            }
            
            // 価格を加算
            $totalPrice += $option->priceDelta->getValue() * $selectionInput->quantity;
            
            // 選択を作成
            $selectionId = Str::uuid()->toString();
            $selections[] = new OptionSelection(
                $selectionId,
                $configurationId,
                $optionId,
                $selectionInput->quantity
            );
        }
        
        // 必須オプションのチェック
        foreach ($boxLunch->options as $option) {
            if ($option->isRequired) {
                $found = false;
                foreach ($selections as $selection) {
                    if ($selection->optionId->getValue() === $option->optionId->getValue()) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    throw new \RuntimeException('必須オプションが選択されていません: ' . $option->name);
                }
            }
        }
        $availabilityStatus = new AvailabilityStatus($input->availabilityStatus);
        $totalPriceObj = new BoxLunchPrice($totalPrice);
        
        $configuration = new BoxLunchConfiguration(
            $configurationId,
            $boxLunchId,
            $availabilityStatus,
            $totalPriceObj,
            $selections
        );
        
        $this->configurationRepository->save($configuration);
        
        return new CreateBoxLunchConfigurationOutputData(
            $configurationId->getValue(),
            $totalPrice,
            'Box Lunch構成が作成されました。'
        );
    }
}

