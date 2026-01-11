<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain\ValueObject;

use InvalidArgumentException;

class OptionId
{
    public function __construct(
        private readonly string $value
    ) {
        if (empty($value)) {
            throw new InvalidArgumentException('オプションIDは必須です。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

