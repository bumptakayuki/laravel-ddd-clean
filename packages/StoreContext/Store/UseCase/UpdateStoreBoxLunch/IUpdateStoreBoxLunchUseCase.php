<?php
namespace Packages\StoreContext\Store\UseCase\UpdateStoreBoxLunch;

interface IUpdateStoreBoxLunchUseCase
{
    public function handle(UpdateStoreBoxLunchInputData $input): UpdateStoreBoxLunchOutputData;
}



