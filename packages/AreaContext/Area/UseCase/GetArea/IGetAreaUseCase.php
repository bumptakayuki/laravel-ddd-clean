<?php
namespace Packages\AreaContext\Area\UseCase\GetArea;

interface IGetAreaUseCase
{
    public function handle(GetAreaInputData $input): GetAreaOutputData;
}

