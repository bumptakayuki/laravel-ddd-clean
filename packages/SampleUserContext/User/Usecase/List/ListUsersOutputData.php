<?php
namespace Packages\User\User\UseCase\ListUsers;

class ListUsersOutputData
{
    public function __construct(
        public readonly array $users
    ) {}
}
