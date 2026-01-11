<?php
namespace Packages\SampleUserContext\User\Domain\ValueObject;

use InvalidArgumentException;

class UserName
{
    public function __construct(
        private readonly string $value
    ) {
        if (empty($value)) {
            throw new InvalidArgumentException('名前は必須です。');
        }

        if (mb_strlen($value) > 50) {
            throw new InvalidArgumentException('名前は50文字以内で入力してください。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
