<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration;

class CreateBoxLunchConfigurationOutputData
{
    public function __construct(
        public readonly string $configurationId,
        public readonly float $totalPrice,
        public readonly string $message
    ) {}
}


