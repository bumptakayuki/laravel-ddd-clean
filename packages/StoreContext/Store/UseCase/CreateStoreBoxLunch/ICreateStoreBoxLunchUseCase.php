<?php
namespace Packages\StoreContext\Store\UseCase\CreateStoreBoxLunch;

interface ICreateStoreBoxLunchUseCase
{
    public function handle(CreateStoreBoxLunchInputData $input): CreateStoreBoxLunchOutputData;
}



