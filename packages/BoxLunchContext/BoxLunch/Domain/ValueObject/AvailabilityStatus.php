<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain\ValueObject;

use InvalidArgumentException;

class AvailabilityStatus
{
    public const AVAILABLE = 'available';
    public const UNAVAILABLE = 'unavailable';
    public const OUT_OF_STOCK = 'out_of_stock';

    private const VALID_STATUSES = [
        self::AVAILABLE,
        self::UNAVAILABLE,
        self::OUT_OF_STOCK,
    ];

    public function __construct(
        private readonly string $value
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (!in_array($this->value, self::VALID_STATUSES, true)) {
            throw new InvalidArgumentException('無効な提供可否状態です。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

