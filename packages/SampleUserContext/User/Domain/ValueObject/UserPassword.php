<?php
namespace Packages\User\User\Domain\ValueObject;

use InvalidArgumentException;

class UserPassword
{
    public function __construct(
        private readonly string $value
    ) {
        if (strlen($value) < 8) {
            throw new InvalidArgumentException('パスワードは8文字以上である必要があります。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
