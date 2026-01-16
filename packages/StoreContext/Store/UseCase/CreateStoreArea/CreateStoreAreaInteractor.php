<?php
namespace Packages\StoreContext\Store\UseCase\CreateStoreArea;

use Packages\StoreContext\Store\Domain\StoreArea;
use Packages\StoreContext\Store\Domain\Repository\StoreRepositoryInterface;
use Packages\StoreContext\Store\Domain\Repository\StoreAreaRepositoryInterface;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

class CreateStoreAreaInteractor implements ICreateStoreAreaUseCase
{
    public function __construct(
        private readonly StoreRepositoryInterface $storeRepository,
        private readonly StoreAreaRepositoryInterface $storeAreaRepository
    ) {}
    
    public function handle(CreateStoreAreaInputData $input): CreateStoreAreaOutputData
    {
        $storeId = new StoreId($input->storeId);
        $store = $this->storeRepository->findById($storeId);
        
        if (!$store) {
            throw new \InvalidArgumentException('店舗が見つかりません。');
        }
        
        $storeArea = new StoreArea(
            $storeId,
            $input->areaId,
            $input->isDeliverable
        );
        
        $this->storeAreaRepository->save($storeArea);
        
        return new CreateStoreAreaOutputData('店舗の配達可能エリア情報が作成されました。');
    }
}


