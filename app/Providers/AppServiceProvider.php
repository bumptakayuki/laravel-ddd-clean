<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// User Context ユースケース
use Packages\User\User\UseCase\CreateUser\ICreateUserUseCase;
use Packages\User\User\UseCase\CreateUser\CreateUserInteractor;
use Packages\User\User\UseCase\ListUsers\IListUsersUseCase;
use Packages\User\User\UseCase\ListUsers\ListUsersInteractor;
use Packages\User\User\UseCase\UpdateUser\IUpdateUserUseCase;
use Packages\User\User\UseCase\UpdateUser\UpdateUserInteractor;
use Packages\User\User\UseCase\DeleteUser\IDeleteUserUseCase;
use Packages\User\User\UseCase\DeleteUser\DeleteUserInteractor;

// User Context リポジトリ
use Packages\User\User\Domain\Repository\UserRepositoryInterface;
use Packages\User\User\Infrastructure\Eloquent\Repository\EloquentUserRepository;

// Order Context ユースケース
use Packages\OrderContext\Order\UseCase\CreateOrder\ICreateOrderUseCase;
use Packages\OrderContext\Order\UseCase\CreateOrder\CreateOrderInteractor;
use Packages\OrderContext\Order\UseCase\ListOrders\IListOrdersUseCase;
use Packages\OrderContext\Order\UseCase\ListOrders\ListOrdersInteractor;
use Packages\OrderContext\Order\UseCase\CreatePayment\ICreatePaymentUseCase;
use Packages\OrderContext\Order\UseCase\CreatePayment\CreatePaymentInteractor;
use Packages\OrderContext\Order\UseCase\CreateAcceptance\ICreateAcceptanceUseCase;
use Packages\OrderContext\Order\UseCase\CreateAcceptance\CreateAcceptanceInteractor;
use Packages\OrderContext\Order\UseCase\CreatePurchase\ICreatePurchaseUseCase;
use Packages\OrderContext\Order\UseCase\CreatePurchase\CreatePurchaseInteractor;

// Order Context リポジトリ
use Packages\OrderContext\Order\Domain\Repository\OrderRepositoryInterface;
use Packages\OrderContext\Order\Infrastructure\Eloquent\Repository\OrderRepository;

// BoxLunch Context ユースケース
use Packages\BoxLunchContext\BoxLunch\UseCase\ListBoxLunches\IListBoxLunchesUseCase;
use Packages\BoxLunchContext\BoxLunch\UseCase\ListBoxLunches\ListBoxLunchesInteractor;
use Packages\BoxLunchContext\BoxLunch\UseCase\GetBoxLunchDetail\IGetBoxLunchDetailUseCase;
use Packages\BoxLunchContext\BoxLunch\UseCase\GetBoxLunchDetail\GetBoxLunchDetailInteractor;
use Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration\ICreateBoxLunchConfigurationUseCase;
use Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration\CreateBoxLunchConfigurationInteractor;

// BoxLunch Context リポジトリ
use Packages\BoxLunchContext\BoxLunch\Domain\Repository\BoxLunchRepositoryInterface;
use Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Repository\BoxLunchRepository;
use Packages\BoxLunchContext\BoxLunch\Domain\Repository\BoxLunchConfigurationRepositoryInterface;
use Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Repository\BoxLunchConfigurationRepository;

// Area Context ユースケース
use Packages\AreaContext\Area\UseCase\ListAreas\IListAreasUseCase;
use Packages\AreaContext\Area\UseCase\ListAreas\ListAreasInteractor;
use Packages\AreaContext\Area\UseCase\GetArea\IGetAreaUseCase;
use Packages\AreaContext\Area\UseCase\GetArea\GetAreaInteractor;

// Area Context リポジトリ
use Packages\AreaContext\Area\Domain\Repository\AreaRepositoryInterface;
use Packages\AreaContext\Area\Infrastructure\Eloquent\Repository\AreaRepository;

// Purchase Context ユースケース
use Packages\PurchaseContext\Purchase\UseCase\ConfirmPurchase\IConfirmPurchaseUseCase;
use Packages\PurchaseContext\Purchase\UseCase\ConfirmPurchase\ConfirmPurchaseInteractor;
use Packages\PurchaseContext\Purchase\UseCase\GetPurchase\IGetPurchaseUseCase;
use Packages\PurchaseContext\Purchase\UseCase\GetPurchase\GetPurchaseInteractor;
use Packages\PurchaseContext\Purchase\UseCase\ListPurchases\IListPurchasesUseCase;
use Packages\PurchaseContext\Purchase\UseCase\ListPurchases\ListPurchasesInteractor;

// Purchase Context リポジトリ
use Packages\PurchaseContext\Purchase\Domain\Repository\PurchaseRepositoryInterface;
use Packages\PurchaseContext\Purchase\Infrastructure\Eloquent\Repository\PurchaseRepository;

// Store Context ユースケース
use Packages\StoreContext\Store\UseCase\CreateStore\ICreateStoreUseCase;
use Packages\StoreContext\Store\UseCase\CreateStore\CreateStoreInteractor;
use Packages\StoreContext\Store\UseCase\UpdateStore\IUpdateStoreUseCase;
use Packages\StoreContext\Store\UseCase\UpdateStore\UpdateStoreInteractor;
use Packages\StoreContext\Store\UseCase\ListStores\IListStoresUseCase;
use Packages\StoreContext\Store\UseCase\ListStores\ListStoresInteractor;
use Packages\StoreContext\Store\UseCase\GetStoreDetail\IGetStoreDetailUseCase;
use Packages\StoreContext\Store\UseCase\GetStoreDetail\GetStoreDetailInteractor;
use Packages\StoreContext\Store\UseCase\CreateStoreBoxLunch\ICreateStoreBoxLunchUseCase;
use Packages\StoreContext\Store\UseCase\CreateStoreBoxLunch\CreateStoreBoxLunchInteractor;
use Packages\StoreContext\Store\UseCase\UpdateStoreBoxLunch\IUpdateStoreBoxLunchUseCase;
use Packages\StoreContext\Store\UseCase\UpdateStoreBoxLunch\UpdateStoreBoxLunchInteractor;
use Packages\StoreContext\Store\UseCase\CreateStoreArea\ICreateStoreAreaUseCase;
use Packages\StoreContext\Store\UseCase\CreateStoreArea\CreateStoreAreaInteractor;
use Packages\StoreContext\Store\UseCase\UpdateStoreArea\IUpdateStoreAreaUseCase;
use Packages\StoreContext\Store\UseCase\UpdateStoreArea\UpdateStoreAreaInteractor;

// Store Context リポジトリ
use Packages\StoreContext\Store\Domain\Repository\StoreRepositoryInterface;
use Packages\StoreContext\Store\Infrastructure\Eloquent\Repository\StoreRepository;
use Packages\StoreContext\Store\Domain\Repository\StoreBoxLunchRepositoryInterface;
use Packages\StoreContext\Store\Infrastructure\Eloquent\Repository\StoreBoxLunchRepository;
use Packages\StoreContext\Store\Domain\Repository\StoreAreaRepositoryInterface;
use Packages\StoreContext\Store\Infrastructure\Eloquent\Repository\StoreAreaRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // User Context: Repository Interface ⇔ Eloquent 実装
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);

        // User Context: UseCase Interface ⇔ Interactor 実装
        $this->app->bind(ICreateUserUseCase::class, CreateUserInteractor::class);
        $this->app->bind(IListUsersUseCase::class, ListUsersInteractor::class);
        $this->app->bind(IUpdateUserUseCase::class, UpdateUserInteractor::class);
        $this->app->bind(IDeleteUserUseCase::class, DeleteUserInteractor::class);

        // Order Context: Repository Interface ⇔ Eloquent 実装
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

        // Order Context: UseCase Interface ⇔ Interactor 実装
        $this->app->bind(ICreateOrderUseCase::class, CreateOrderInteractor::class);
        
        $this->app->bind(IListOrdersUseCase::class, ListOrdersInteractor::class);
        $this->app->bind(ICreatePaymentUseCase::class, CreatePaymentInteractor::class);
        $this->app->bind(ICreateAcceptanceUseCase::class, CreateAcceptanceInteractor::class);
        $this->app->bind(ICreatePurchaseUseCase::class, CreatePurchaseInteractor::class);

        // BoxLunch Context: Repository Interface ⇔ Eloquent 実装
        $this->app->bind(BoxLunchRepositoryInterface::class, BoxLunchRepository::class);
        $this->app->bind(BoxLunchConfigurationRepositoryInterface::class, BoxLunchConfigurationRepository::class);

        // BoxLunch Context: UseCase Interface ⇔ Interactor 実装
        $this->app->bind(IListBoxLunchesUseCase::class, ListBoxLunchesInteractor::class);
        $this->app->bind(IGetBoxLunchDetailUseCase::class, GetBoxLunchDetailInteractor::class);
        $this->app->bind(ICreateBoxLunchConfigurationUseCase::class, CreateBoxLunchConfigurationInteractor::class);

        // Area Context: Repository Interface ⇔ Eloquent 実装
        $this->app->bind(AreaRepositoryInterface::class, AreaRepository::class);

        // Area Context: UseCase Interface ⇔ Interactor 実装
        $this->app->bind(IListAreasUseCase::class, ListAreasInteractor::class);
        $this->app->bind(IGetAreaUseCase::class, GetAreaInteractor::class);

        // Purchase Context: Repository Interface ⇔ Eloquent 実装
        $this->app->bind(PurchaseRepositoryInterface::class, PurchaseRepository::class);

        // Purchase Context: UseCase Interface ⇔ Interactor 実装
        $this->app->bind(IConfirmPurchaseUseCase::class, ConfirmPurchaseInteractor::class);
        $this->app->bind(IGetPurchaseUseCase::class, GetPurchaseInteractor::class);
        $this->app->bind(IListPurchasesUseCase::class, ListPurchasesInteractor::class);

        // Store Context: Repository Interface ⇔ Eloquent 実装
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(StoreBoxLunchRepositoryInterface::class, StoreBoxLunchRepository::class);
        $this->app->bind(StoreAreaRepositoryInterface::class, StoreAreaRepository::class);

        // Store Context: UseCase Interface ⇔ Interactor 実装
        $this->app->bind(ICreateStoreUseCase::class, CreateStoreInteractor::class);
        $this->app->bind(IUpdateStoreUseCase::class, UpdateStoreInteractor::class);
        $this->app->bind(IListStoresUseCase::class, ListStoresInteractor::class);
        $this->app->bind(IGetStoreDetailUseCase::class, GetStoreDetailInteractor::class);
        $this->app->bind(ICreateStoreBoxLunchUseCase::class, CreateStoreBoxLunchInteractor::class);
        $this->app->bind(IUpdateStoreBoxLunchUseCase::class, UpdateStoreBoxLunchInteractor::class);
        $this->app->bind(ICreateStoreAreaUseCase::class, CreateStoreAreaInteractor::class);
        $this->app->bind(IUpdateStoreAreaUseCase::class, UpdateStoreAreaInteractor::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
