<?php
namespace Packages\AreaContext\Area\Domain\ValueObject;

use InvalidArgumentException;

class AreaId
{
    public function __construct(
        private readonly string $value
    ) {
        if (empty($value)) {
            throw new InvalidArgumentException('エリアIDは必須です。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}


