<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain;

use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\ConfigurationId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\AvailabilityStatus;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchPrice;

class BoxLunchConfiguration
{
    /**
     * @param OptionSelection[] $selections
     */
    public function __construct(
        public readonly ConfigurationId $configurationId,
        public readonly BoxLunchId $boxLunchId,
        public readonly AvailabilityStatus $availabilityStatus,
        public readonly BoxLunchPrice $totalPrice,
        public readonly array $selections = []
    ) {}
}


