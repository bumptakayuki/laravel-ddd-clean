<?php
namespace Packages\StoreContext\Store\UseCase\CreateStoreArea;

interface ICreateStoreAreaUseCase
{
    public function handle(CreateStoreAreaInputData $input): CreateStoreAreaOutputData;
}


