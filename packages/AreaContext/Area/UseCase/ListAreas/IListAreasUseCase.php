<?php
namespace Packages\AreaContext\Area\UseCase\ListAreas;

interface IListAreasUseCase
{
    public function handle(ListAreasInputData $input): ListAreasOutputData;
}



