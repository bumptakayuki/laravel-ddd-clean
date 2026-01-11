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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
