<?php
namespace Packages\User\User\UseCase\DeleteUser;

interface IDeleteUserUseCase
{
    public function handle(DeleteUserInputData $input): void;
}
