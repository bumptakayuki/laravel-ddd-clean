<?php
namespace Packages\SampleUserContext\User\UseCase\ListUsers;

class ListUsersOutputData
{
    public function __construct(
        public readonly array $users
    ) {}
}
