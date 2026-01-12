<?php
namespace Packages\StoreContext\Store\Domain\ValueObject;

use InvalidArgumentException;

class StoreId
{
    public function __construct(
        private readonly string $value
    ) {
        if (empty($value)) {
            throw new InvalidArgumentException('店舗IDは必須です。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

