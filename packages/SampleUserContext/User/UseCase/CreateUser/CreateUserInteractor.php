<?php
namespace Packages\SampleUserContext\User\UseCase\CreateUser;

use Packages\SampleUserContext\User\Domain\User;
use Packages\SampleUserContext\User\Domain\Repository\UserRepositoryInterface;

class CreateUserInteractor implements ICreateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function handle(CreateUserInputData $input): void
    {
        $user = new User($input->name, $input->email, $input->password);
        $this->userRepository->save($user);
    }
}
