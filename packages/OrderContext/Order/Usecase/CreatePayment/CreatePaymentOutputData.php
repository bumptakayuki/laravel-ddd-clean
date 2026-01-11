<?php
namespace Packages\OrderContext\Order\UseCase\CreatePayment;

class CreatePaymentOutputData
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $message
    ) {}
}

