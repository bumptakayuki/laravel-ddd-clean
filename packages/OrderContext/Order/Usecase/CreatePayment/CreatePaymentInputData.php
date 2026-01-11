<?php
namespace Packages\OrderContext\Order\UseCase\CreatePayment;

class CreatePaymentInputData
{
    public function __construct(
        public readonly string $orderId,
        public readonly string $method,
        public readonly ?string $transactionId = null
    ) {}
}

