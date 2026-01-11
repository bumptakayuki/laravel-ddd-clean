<?php
namespace Packages\SampleUserContext\User\UseCase\ListUsers;

use Packages\SampleUserContext\User\Domain\Repository\UserRepositoryInterface;

class ListUsersInteractor implements IListUsersUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}
    
    public function handle(): ListUsersOutputData
    {
        $users = $this->userRepository->findAll();
        
        // ドメインエンティティを配列に変換
        $usersArray = [];
        foreach ($users as $user) {
            $usersArray[] = [
                'name' => $user->name,
                'email' => $user->email,
            ];
        }

        return new ListUsersOutputData($usersArray);
    }
}
