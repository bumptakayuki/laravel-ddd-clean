<?php
namespace Packages\User\User\Infrastructure\Eloquent\Repository;

use Packages\User\User\Domain\Entity\User;
use Packages\User\User\Domain\Repository\UserRepositoryInterface;
use Packages\User\User\Infrastructure\Eloquent\Model\EloquentUser;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        EloquentUser::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($user->password),
        ]);
    }
}
