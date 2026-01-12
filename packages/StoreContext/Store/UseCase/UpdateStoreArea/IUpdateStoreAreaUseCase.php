<?php
namespace Packages\StoreContext\Store\UseCase\UpdateStoreArea;

interface IUpdateStoreAreaUseCase
{
    public function handle(UpdateStoreAreaInputData $input): UpdateStoreAreaOutputData;
}

