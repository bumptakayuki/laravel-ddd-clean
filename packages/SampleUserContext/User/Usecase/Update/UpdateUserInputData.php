<?php

namespace Packages\User\User\UseCase\UpdateUser;

class UpdateUserInputData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
    ) {}
}
