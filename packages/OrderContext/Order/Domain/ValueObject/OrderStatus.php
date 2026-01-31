<?php
namespace Packages\OrderContext\Order\Domain\ValueObject;

use InvalidArgumentException;

class OrderStatus
{
    public const PENDING = 'pending';
    public const CONFIRMED = 'confirmed';
    public const PREPARING = 'preparing';
    public const READY = 'ready';
    public const DELIVERED = 'delivered';
    public const CANCELLED = 'cancelled';

    private const VALID_STATUSES = [
        self::PENDING,
        self::CONFIRMED,
        self::PREPARING,
        self::READY,
        self::DELIVERED,
        self::CANCELLED,
    ];

    public function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::VALID_STATUSES, true)) {
            throw new InvalidArgumentException(
                sprintf('無効な注文状態です: %s', $value)
            );
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}



