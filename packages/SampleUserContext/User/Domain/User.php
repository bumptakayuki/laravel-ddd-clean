<?php
namespace Packages\SampleUserContext\User\Domain;

class User
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}
}
