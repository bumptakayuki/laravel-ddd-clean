<?php
namespace Packages\StoreContext\Store\UseCase\CreateStoreBoxLunch;

use Packages\StoreContext\Store\Domain\StoreBoxLunch;
use Packages\StoreContext\Store\Domain\Repository\StoreRepositoryInterface;
use Packages\StoreContext\Store\Domain\Repository\StoreBoxLunchRepositoryInterface;
use Packages\StoreContext\Store\Domain\ValueObject\StoreId;

class CreateStoreBoxLunchInteractor implements ICreateStoreBoxLunchUseCase
{
    public function __construct(
        private readonly StoreRepositoryInterface $storeRepository,
        private readonly StoreBoxLunchRepositoryInterface $storeBoxLunchRepository
    ) {}
    
    public function handle(CreateStoreBoxLunchInputData $input): CreateStoreBoxLunchOutputData
    {
        $storeId = new StoreId($input->storeId);
        $store = $this->storeRepository->findById($storeId);
        
        if (!$store) {
            throw new \InvalidArgumentException('店舗が見つかりません。');
        }
        
        $storeBoxLunch = new StoreBoxLunch(
            $storeId,
            $input->boxLunchId,
            $input->isAvailable
        );
        
        $this->storeBoxLunchRepository->save($storeBoxLunch);
        
        return new CreateStoreBoxLunchOutputData('店舗の弁当提供情報が作成されました。');
    }
}


