<?php
namespace Packages\User\User\UseCase\ListUsers;

use Packages\User\User\Infrastructure\Eloquent\Model\EloquentUser;

class ListUsersInteractor implements IListUsersUseCase
{
    public function handle(): ListUsersOutputData
    {
        $users = EloquentUser::all()->toArray();

        return new ListUsersOutputData($users);
    }
}
