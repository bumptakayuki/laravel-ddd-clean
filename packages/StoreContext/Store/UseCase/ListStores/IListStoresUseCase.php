<?php
namespace Packages\StoreContext\Store\UseCase\ListStores;

interface IListStoresUseCase
{
    public function handle(ListStoresInputData $input): ListStoresOutputData;
}


