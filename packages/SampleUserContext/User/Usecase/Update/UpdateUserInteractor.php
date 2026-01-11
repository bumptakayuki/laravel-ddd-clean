<?php
namespace Packages\User\User\UseCase\UpdateUser;

use Packages\User\User\Infrastructure\Eloquent\Model\EloquentUser;

class UpdateUserInteractor implements IUpdateUserUseCase
{
    public function handle(UpdateUserInputData $input): void
    {
        $user = EloquentUser::findOrFail($input->id);

        $user->update([
            'name' => $input->name,
            'email' => $input->email,
        ]);
    }
}
