<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration;

class CreateBoxLunchConfigurationOptionSelectionInputData
{
    public function __construct(
        public readonly string $optionId,
        public readonly int $quantity
    ) {}
}



