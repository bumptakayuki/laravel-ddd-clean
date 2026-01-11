<?php
namespace Packages\SampleUserContext\User\UseCase\CreateUser;

interface ICreateUserUseCase
{
    public function handle(CreateUserInputData $input): void;
}
