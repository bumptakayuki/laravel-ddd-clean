<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// ユースケース
use Packages\User\User\UseCase\CreateUser\ICreateUserUseCase;
use Packages\User\User\UseCase\CreateUser\CreateUserInteractor;
use Packages\User\User\UseCase\ListUsers\IListUsersUseCase;
use Packages\User\User\UseCase\ListUsers\ListUsersInteractor;
use Packages\User\User\UseCase\UpdateUser\IUpdateUserUseCase;
use Packages\User\User\UseCase\UpdateUser\UpdateUserInteractor;
use Packages\User\User\UseCase\DeleteUser\IDeleteUserUseCase;
use Packages\User\User\UseCase\DeleteUser\DeleteUserInteractor;

// リポジトリ
use Packages\User\User\Domain\Repository\UserRepositoryInterface;
use Packages\User\User\Infrastructure\Eloquent\Repository\EloquentUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository Interface ⇔ Eloquent 実装
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);

        // UseCase Interface ⇔ Interactor 実装
        $this->app->bind(ICreateUserUseCase::class, CreateUserInteractor::class);
        $this->app->bind(IListUsersUseCase::class, ListUsersInteractor::class);
        $this->app->bind(IUpdateUserUseCase::class, UpdateUserInteractor::class);
        $this->app->bind(IDeleteUserUseCase::class, DeleteUserInteractor::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
