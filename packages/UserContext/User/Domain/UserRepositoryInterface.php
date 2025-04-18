<?php
namespace Packages\User\User\Domain\Repository;

use Packages\User\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
}
