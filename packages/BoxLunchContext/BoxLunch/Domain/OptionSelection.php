<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain;

use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\ConfigurationId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\OptionId;

class OptionSelection
{
    public function __construct(
        public readonly string $selectionId,
        public readonly ConfigurationId $configurationId,
        public readonly OptionId $optionId,
        public readonly int $quantity
    ) {}
}



