<?php
namespace Packages\AreaContext\Area\Domain\ValueObject;

use InvalidArgumentException;

class AreaName
{
    public function __construct(
        private readonly string $value
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException('エリア名は必須です。');
        }

        if (mb_strlen($this->value) > 100) {
            throw new InvalidArgumentException('エリア名は100文字以内で入力してください。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

