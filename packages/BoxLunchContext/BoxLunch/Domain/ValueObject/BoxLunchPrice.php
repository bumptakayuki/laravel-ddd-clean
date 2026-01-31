<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain\ValueObject;

use InvalidArgumentException;

class BoxLunchPrice
{
    public function __construct(
        private readonly float $value
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->value < 0) {
            throw new InvalidArgumentException('価格は0以上である必要があります。');
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }
}



