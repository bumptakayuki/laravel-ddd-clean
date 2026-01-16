<?php
namespace Packages\StoreContext\Store\UseCase\UpdateStoreBoxLunch;

use Packages\StoreContext\Store\Domain\Repository\StoreBoxLunchRepositoryInterface;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

class UpdateStoreBoxLunchInteractor implements IUpdateStoreBoxLunchUseCase
{
    public function __construct(
        private readonly StoreBoxLunchRepositoryInterface $storeBoxLunchRepository
    ) {}
    
    public function handle(UpdateStoreBoxLunchInputData $input): UpdateStoreBoxLunchOutputData
    {
        $storeId = new StoreId($input->storeId);
        $storeBoxLunch = $this->storeBoxLunchRepository->findByStoreIdAndBoxLunchId($storeId, $input->boxLunchId);
        
        if (!$storeBoxLunch) {
            throw new \InvalidArgumentException('店舗の弁当提供情報が見つかりません。');
        }
        
        $updatedStoreBoxLunch = $input->isAvailable 
            ? $storeBoxLunch->makeAvailable() 
            : $storeBoxLunch->makeUnavailable();
        
        $this->storeBoxLunchRepository->save($updatedStoreBoxLunch);
        
        return new UpdateStoreBoxLunchOutputData('店舗の弁当提供情報が更新されました。');
    }
}


