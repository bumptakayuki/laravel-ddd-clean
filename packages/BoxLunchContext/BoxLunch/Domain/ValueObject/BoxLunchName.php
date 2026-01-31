<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain\ValueObject;

use InvalidArgumentException;

class BoxLunchName
{
    public function __construct(
        private readonly string $value
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException('弁当名は必須です。');
        }

        if (mb_strlen($this->value) > 100) {
            throw new InvalidArgumentException('弁当名は100文字以内で入力してください。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}



