<?php
namespace Packages\OrderContext\Order\UseCase\CreateAcceptance;

class CreateAcceptanceOutputData
{
    public function __construct(
        public readonly string $acceptanceId,
        public readonly string $message
    ) {}
}

