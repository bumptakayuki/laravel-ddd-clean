<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain\ValueObject;

use InvalidArgumentException;

class ConfigurationId
{
    public function __construct(
        private readonly string $value
    ) {
        if (empty($value)) {
            throw new InvalidArgumentException('構成IDは必須です。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}


