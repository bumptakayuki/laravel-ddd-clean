<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\GetBoxLunchDetail;

interface IGetBoxLunchDetailUseCase
{
    public function handle(GetBoxLunchDetailInputData $input): GetBoxLunchDetailOutputData;
}



