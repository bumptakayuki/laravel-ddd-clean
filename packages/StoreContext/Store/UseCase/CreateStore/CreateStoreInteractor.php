<?php
namespace Packages\StoreContext\Store\UseCase\CreateStore;

use Packages\StoreContext\Store\Domain\Store;
use Packages\StoreContext\Store\Domain\Repository\StoreRepositoryInterface;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;
use Packages\StoreContext\Store\Domain\ValueObject\StoreName;
use Packages\StoreContext\Store\Domain\ValueObject\StoreAddress;
use Illuminate\Support\Str;

class CreateStoreInteractor implements ICreateStoreUseCase
{
    public function __construct(
        private readonly StoreRepositoryInterface $storeRepository
    ) {}
    
    public function handle(CreateStoreInputData $input): CreateStoreOutputData
    {
        $storeId = new StoreId(Str::uuid()->toString());
        $name = new StoreName($input->name);
        $address = new StoreAddress($input->address);
        
        $store = new Store(
            $storeId,
            $name,
            $address,
            $input->isOpen
        );
        
        $this->storeRepository->save($store);
        
        return new CreateStoreOutputData(
            $storeId->getValue(),
            '店舗が作成されました。'
        );
    }
}


