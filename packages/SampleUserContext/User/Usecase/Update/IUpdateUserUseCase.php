<?php

namespace Packages\User\User\UseCase\UpdateUser;

interface IUpdateUserUseCase
{
    public function handle(UpdateUserInputData $input): void;
}
