<?php

namespace Packages\SampleUserContext\User\UseCase\UpdateUser;

class UpdateUserInputData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
    ) {}
}
