<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain\ValueObject;

use InvalidArgumentException;

class BoxLunchId
{
    public function __construct(
        private readonly string $value
    ) {
        if (empty($value)) {
            throw new InvalidArgumentException('弁当IDは必須です。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}



