<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\CreateBoxLunchConfiguration;

class CreateBoxLunchConfigurationInputData
{
    /**
     * @param CreateBoxLunchConfigurationOptionSelectionInputData[] $selections
     */
    public function __construct(
        public readonly string $boxLunchId,
        public readonly string $availabilityStatus,
        public readonly array $selections
    ) {}
}


