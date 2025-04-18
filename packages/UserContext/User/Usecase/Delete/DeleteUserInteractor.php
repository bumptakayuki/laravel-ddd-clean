<?php
namespace Packages\User\User\UseCase\DeleteUser;

use Packages\User\User\Infrastructure\Eloquent\Model\EloquentUser;

class DeleteUserInteractor implements IDeleteUserUseCase
{
    public function handle(DeleteUserInputData $input): void
    {
        $user = EloquentUser::findOrFail($input->id);
        $user->delete();
    }
}
