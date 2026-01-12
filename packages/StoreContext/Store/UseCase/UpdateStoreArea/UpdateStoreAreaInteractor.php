<?php
namespace Packages\StoreContext\Store\UseCase\UpdateStoreArea;

use Packages\StoreContext\Store\Domain\Repository\StoreAreaRepositoryInterface;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

class UpdateStoreAreaInteractor implements IUpdateStoreAreaUseCase
{
    public function __construct(
        private readonly StoreAreaRepositoryInterface $storeAreaRepository
    ) {}
    
    public function handle(UpdateStoreAreaInputData $input): UpdateStoreAreaOutputData
    {
        $storeId = new StoreId($input->storeId);
        $storeArea = $this->storeAreaRepository->findByStoreIdAndAreaId($storeId, $input->areaId);
        
        if (!$storeArea) {
            throw new \InvalidArgumentException('店舗の配達可能エリア情報が見つかりません。');
        }
        
        $updatedStoreArea = $input->isDeliverable 
            ? $storeArea->makeDeliverable() 
            : $storeArea->makeUndeliverable();
        
        $this->storeAreaRepository->save($updatedStoreArea);
        
        return new UpdateStoreAreaOutputData('店舗の配達可能エリア情報が更新されました。');
    }
}

