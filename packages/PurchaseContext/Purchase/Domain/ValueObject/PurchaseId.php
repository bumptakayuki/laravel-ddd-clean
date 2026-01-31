<?php
namespace Packages\PurchaseContext\Purchase\Domain\ValueObject;

use InvalidArgumentException;

class PurchaseId
{
    public function __construct(
        private readonly string $value
    ) {
        if (empty($value)) {
            throw new InvalidArgumentException('購入IDは必須です。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}



