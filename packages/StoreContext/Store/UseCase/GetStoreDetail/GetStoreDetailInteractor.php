<?php
namespace Packages\StoreContext\Store\UseCase\GetStoreDetail;

use Packages\StoreContext\Store\Domain\Repository\StoreRepositoryInterface;
use Packages\StoreContext\Store\Domain\Repository\StoreBoxLunchRepositoryInterface;
use Packages\StoreContext\Store\Domain\Repository\StoreAreaRepositoryInterface;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

class GetStoreDetailInteractor implements IGetStoreDetailUseCase
{
    public function __construct(
        private readonly StoreRepositoryInterface $storeRepository,
        private readonly StoreBoxLunchRepositoryInterface $storeBoxLunchRepository,
        private readonly StoreAreaRepositoryInterface $storeAreaRepository
    ) {}
    
    public function handle(GetStoreDetailInputData $input): GetStoreDetailOutputData
    {
        $storeId = new StoreId($input->storeId);
        $store = $this->storeRepository->findById($storeId);
        
        if (!$store) {
            throw new \InvalidArgumentException('店舗が見つかりません。');
        }
        
        $storeBoxLunches = $this->storeBoxLunchRepository->findByStoreId($storeId);
        $storeAreas = $this->storeAreaRepository->findByStoreId($storeId);
        
        $storeBoxLunchData = [];
        foreach ($storeBoxLunches as $storeBoxLunch) {
            $storeBoxLunchData[] = [
                'box_lunch_id' => $storeBoxLunch->boxLunchId,
                'is_available' => $storeBoxLunch->isAvailable,
            ];
        }
        
        $storeAreaData = [];
        foreach ($storeAreas as $storeArea) {
            $storeAreaData[] = [
                'area_id' => $storeArea->areaId,
                'is_deliverable' => $storeArea->isDeliverable,
            ];
        }
        
        $storeData = [
            'store_id' => $store->storeId->getValue(),
            'name' => $store->name->getValue(),
            'address' => $store->address->getValue(),
            'is_open' => $store->isOpen,
            'store_box_lunches' => $storeBoxLunchData,
            'store_areas' => $storeAreaData,
        ];
        
        return new GetStoreDetailOutputData($storeData);
    }
}


