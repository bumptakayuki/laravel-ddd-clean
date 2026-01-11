<?php

namespace Packages\SampleUserContext\User\UseCase\UpdateUser;

interface IUpdateUserUseCase
{
    public function handle(UpdateUserInputData $input): void;
}
