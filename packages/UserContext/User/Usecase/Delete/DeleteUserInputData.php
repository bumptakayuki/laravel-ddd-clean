<?php
namespace Packages\User\User\UseCase\DeleteUser;

class DeleteUserInputData
{
    public function __construct(
        public readonly int $id
    ) {}
}
