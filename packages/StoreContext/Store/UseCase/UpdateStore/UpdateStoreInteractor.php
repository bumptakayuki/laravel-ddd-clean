<?php
namespace Packages\StoreContext\Store\UseCase\UpdateStore;

use Packages\StoreContext\Store\Domain\Repository\StoreRepositoryInterface;
use Packages\StoreContext\Store\Domain\Store;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;
use Packages\StoreContext\Store\Domain\ValueObject\StoreName;
use Packages\StoreContext\Store\Domain\ValueObject\StoreAddress;

class UpdateStoreInteractor implements IUpdateStoreUseCase
{
    public function __construct(
        private readonly StoreRepositoryInterface $storeRepository
    ) {}
    
    public function handle(UpdateStoreInputData $input): UpdateStoreOutputData
    {
        $storeId = new StoreId($input->storeId);
        $store = $this->storeRepository->findById($storeId);
        
        if (!$store) {
            throw new \InvalidArgumentException('店舗が見つかりません。');
        }
        
        $name = $input->name !== null ? new StoreName($input->name) : $store->name;
        $address = $input->address !== null ? new StoreAddress($input->address) : $store->address;
        $isOpen = $input->isOpen !== null ? $input->isOpen : $store->isOpen;
        
        $updatedStore = new Store(
            $store->storeId,
            $name,
            $address,
            $isOpen
        );
        
        $this->storeRepository->save($updatedStore);
        
        return new UpdateStoreOutputData('店舗が更新されました。');
    }
}

