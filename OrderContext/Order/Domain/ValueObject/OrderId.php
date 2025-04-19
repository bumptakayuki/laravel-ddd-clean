<?php
namespace Packages\Order\Order\Domain\ValueObject;

use Ramsey\Uuid\Uuid;

class OrderId
{
    private string $value;

    public function __construct(string $value = null)
    {
        $this->value = $value ?? Uuid::uuid4()->toString();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
