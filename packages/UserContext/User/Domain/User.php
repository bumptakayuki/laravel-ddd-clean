<?php
namespace Packages\User\User\Domain\Entity;

class User
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}
}
