<?php
namespace Packages\SampleUserContext\User\Infrastructure\Eloquent\Repository;

use Packages\SampleUserContext\User\Domain\User;
use Packages\SampleUserContext\User\Domain\Repository\UserRepositoryInterface;
use Packages\SampleUserContext\User\Infrastructure\Eloquent\Model\EloquentUser;
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
    
    public function findById(int $id): ?User
    {
        $eloquent = EloquentUser::find($id);
        if (!$eloquent) {
            return null;
        }
        
        return $this->toEntity($eloquent);
    }
    
    public function findAll(): array
    {
        $eloquents = EloquentUser::all();
        $users = [];
        foreach ($eloquents as $eloquent) {
            $users[] = $this->toEntity($eloquent);
        }
        
        return $users;
    }
    
    public function delete(User $user): void
    {
        // 注意: このサンプルではUserエンティティにidがないため、実装は簡略化
        // 実際の実装では、エンティティにidを追加する必要がある
    }
    
    private function toEntity(EloquentUser $eloquent): User
    {
        return new User(
            $eloquent->name,
            $eloquent->email,
            '' // パスワードは返さない
        );
    }
}
