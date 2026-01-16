<?php
namespace Packages\OrderContext\Order\Domain\ValueObject;

use InvalidArgumentException;

class OrderItemId
{
    public function __construct(
        private readonly string $value
    ) {
        if (empty($value)) {
            throw new InvalidArgumentException('注文明細IDは必須です。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}


