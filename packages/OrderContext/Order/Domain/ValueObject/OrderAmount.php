<?php
namespace Packages\OrderContext\Order\Domain\ValueObject;

use InvalidArgumentException;

class OrderAmount
{
    public function __construct(
        private readonly float $value
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException('金額は0以上である必要があります。');
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }
}



