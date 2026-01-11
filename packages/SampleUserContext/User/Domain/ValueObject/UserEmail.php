<?php
namespace Packages\SampleUserContext\User\Domain\ValueObject;

use InvalidArgumentException;

class UserEmail
{
    public function __construct(
        private readonly string $value
    ) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('正しいメールアドレス形式で入力してください。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
