<?php
namespace Packages\SampleUserContext\User\UseCase\DeleteUser;

class DeleteUserInputData
{
    public function __construct(
        public readonly int $id
    ) {}
}
