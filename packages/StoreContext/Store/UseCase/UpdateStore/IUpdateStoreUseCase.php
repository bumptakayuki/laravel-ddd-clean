<?php
namespace Packages\StoreContext\Store\UseCase\UpdateStore;

interface IUpdateStoreUseCase
{
    public function handle(UpdateStoreInputData $input): UpdateStoreOutputData;
}

