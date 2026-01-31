<?php
namespace Packages\AreaContext\Area\UseCase\ListAreas;

use Packages\AreaContext\Area\Domain\Repository\AreaRepositoryInterface;

class ListAreasInteractor implements IListAreasUseCase
{
    public function __construct(
        private readonly AreaRepositoryInterface $areaRepository
    ) {}
    
    public function handle(ListAreasInputData $input): ListAreasOutputData
    {
        $areas = $this->areaRepository->findAll();
        
        $areasArray = [];
        foreach ($areas as $area) {
            $areasArray[] = [
                'area_id' => $area->areaId->getValue(),
                'name' => $area->name->getValue(),
            ];
        }
        
        return new ListAreasOutputData($areasArray);
    }
}



