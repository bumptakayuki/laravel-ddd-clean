<?php
namespace Packages\SampleUserContext\User\UseCase\CreateUser;

class CreateUserInputData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}
}
