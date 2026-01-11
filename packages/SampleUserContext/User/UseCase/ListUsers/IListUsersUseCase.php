<?php
namespace Packages\SampleUserContext\User\UseCase\ListUsers;

interface IListUsersUseCase
{
    public function handle(): ListUsersOutputData;
}
