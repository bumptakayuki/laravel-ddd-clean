<?php
namespace Packages\SampleUserContext\User\UseCase\UpdateUser;

use Packages\SampleUserContext\User\Domain\Repository\UserRepositoryInterface;

class UpdateUserInteractor implements IUpdateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}
    
    public function handle(UpdateUserInputData $input): void
    {
        // 注意: このサンプルではUserエンティティにidがないため、実装は簡略化
        // 実際の実装では、エンティティにidを追加し、findByIdで取得して更新する必要がある
    }
}
