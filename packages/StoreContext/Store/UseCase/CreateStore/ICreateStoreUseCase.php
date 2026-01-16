<?php
namespace Packages\StoreContext\Store\UseCase\CreateStore;

interface ICreateStoreUseCase
{
    public function handle(CreateStoreInputData $input): CreateStoreOutputData;
}


