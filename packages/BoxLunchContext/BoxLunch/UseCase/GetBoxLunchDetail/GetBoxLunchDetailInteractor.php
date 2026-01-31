<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\GetBoxLunchDetail;

use Packages\BoxLunchContext\BoxLunch\Domain\Repository\BoxLunchRepositoryInterface;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchId;

class GetBoxLunchDetailInteractor implements IGetBoxLunchDetailUseCase
{
    public function __construct(
        private readonly BoxLunchRepositoryInterface $boxLunchRepository
    ) {}
    
    public function handle(GetBoxLunchDetailInputData $input): GetBoxLunchDetailOutputData
    {
        $boxLunchId = new BoxLunchId($input->boxLunchId);
        $boxLunch = $this->boxLunchRepository->findByIdWithOptions($boxLunchId);
        
        if ($boxLunch === null) {
            throw new \RuntimeException('指定されたBox Lunchが見つかりません。');
        }
        
        $optionsArray = [];
        foreach ($boxLunch->options as $option) {
            $optionsArray[] = [
                'option_id' => $option->optionId->getValue(),
                'name' => $option->name,
                'price_delta' => $option->priceDelta->getValue(),
                'is_required' => $option->isRequired,
            ];
        }
        
        $boxLunchArray = [
            'box_lunch_id' => $boxLunch->boxLunchId->getValue(),
            'name' => $boxLunch->name->getValue(),
            'description' => $boxLunch->description,
            'base_price' => $boxLunch->basePrice->getValue(),
            'is_active' => $boxLunch->isActive,
            'options' => $optionsArray,
        ];
        
        return new GetBoxLunchDetailOutputData($boxLunchArray);
    }
}



