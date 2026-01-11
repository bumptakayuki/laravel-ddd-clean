<?php
namespace Packages\SampleUserContext\User\UseCase\DeleteUser;

interface IDeleteUserUseCase
{
    public function handle(DeleteUserInputData $input): void;
}
