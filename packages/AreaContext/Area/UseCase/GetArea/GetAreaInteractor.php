<?php
namespace Packages\AreaContext\Area\UseCase\GetArea;

use Packages\AreaContext\Area\Domain\Repository\AreaRepositoryInterface;
use Packages\AreaContext\Area\Domain\ValueObject\AreaId;

class GetAreaInteractor implements IGetAreaUseCase
{
    public function __construct(
        private readonly AreaRepositoryInterface $areaRepository
    ) {}
    
    public function handle(GetAreaInputData $input): GetAreaOutputData
    {
        $areaId = new AreaId($input->areaId);
        $area = $this->areaRepository->findById($areaId);
        
        if (!$area) {
            return new GetAreaOutputData(null);
        }
        
        $areaArray = [
            'area_id' => $area->areaId->getValue(),
            'name' => $area->name->getValue(),
        ];
        
        return new GetAreaOutputData($areaArray);
    }
}



