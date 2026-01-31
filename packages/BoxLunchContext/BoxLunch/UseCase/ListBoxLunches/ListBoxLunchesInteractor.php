<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\ListBoxLunches;

use Packages\BoxLunchContext\BoxLunch\Domain\Repository\BoxLunchRepositoryInterface;

class ListBoxLunchesInteractor implements IListBoxLunchesUseCase
{
    public function __construct(
        private readonly BoxLunchRepositoryInterface $boxLunchRepository
    ) {}
    
    public function handle(ListBoxLunchesInputData $input): ListBoxLunchesOutputData
    {
        $boxLunches = $this->boxLunchRepository->findByStoreId($input->storeId);
        
        $boxLunchesArray = [];
        foreach ($boxLunches as $boxLunch) {
            $boxLunchesArray[] = [
                'box_lunch_id' => $boxLunch->boxLunchId->getValue(),
                'name' => $boxLunch->name->getValue(),
                'description' => $boxLunch->description,
                'base_price' => $boxLunch->basePrice->getValue(),
                'is_active' => $boxLunch->isActive,
            ];
        }
        
        return new ListBoxLunchesOutputData($boxLunchesArray);
    }
}



