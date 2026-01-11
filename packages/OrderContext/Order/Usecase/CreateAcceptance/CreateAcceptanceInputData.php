<?php
namespace Packages\OrderContext\Order\UseCase\CreateAcceptance;

class CreateAcceptanceInputData
{
    public function __construct(
        public readonly string $orderId
    ) {}
}

