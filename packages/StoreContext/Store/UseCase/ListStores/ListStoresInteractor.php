<?php
namespace Packages\StoreContext\Store\UseCase\ListStores;

use Packages\StoreContext\Store\Domain\Repository\StoreRepositoryInterface;

class ListStoresInteractor implements IListStoresUseCase
{
    public function __construct(
        private readonly StoreRepositoryInterface $storeRepository
    ) {}
    
    public function handle(ListStoresInputData $input): ListStoresOutputData
    {
        $stores = $this->storeRepository->findAll();
        
        $storeData = [];
        foreach ($stores as $store) {
            $storeData[] = [
                'store_id' => $store->storeId->getValue(),
                'name' => $store->name->getValue(),
                'address' => $store->address->getValue(),
                'is_open' => $store->isOpen,
            ];
        }
        
        return new ListStoresOutputData($storeData);
    }
}



