<?php
namespace Packages\User\User\UseCase\CreateUser;

interface ICreateUserUseCase
{
    public function handle(CreateUserInputData $input): void;
}
