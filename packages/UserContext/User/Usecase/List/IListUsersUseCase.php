<?php
namespace Packages\User\User\UseCase\ListUsers;

interface IListUsersUseCase
{
    public function handle(): ListUsersOutputData;
}
