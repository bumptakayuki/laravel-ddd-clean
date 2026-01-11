<?php
namespace Packages\SampleUserContext\User\UseCase\DeleteUser;

use Packages\SampleUserContext\User\Domain\Repository\UserRepositoryInterface;

class DeleteUserInteractor implements IDeleteUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}
    
    public function handle(DeleteUserInputData $input): void
    {
        // 注意: このサンプルではUserエンティティにidがないため、実装は簡略化
        // 実際の実装では、エンティティにidを追加し、findByIdで取得してdeleteする必要がある
        $user = $this->userRepository->findById($input->id);
        if ($user) {
            $this->userRepository->delete($user);
        }
    }
}
