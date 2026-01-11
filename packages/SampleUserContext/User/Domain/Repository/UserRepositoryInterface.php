<?php
namespace Packages\SampleUserContext\User\Domain\Repository;

use Packages\SampleUserContext\User\Domain\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    
    public function findById(int $id): ?User;
    
    public function findAll(): array;
    
    public function delete(User $user): void;
}
