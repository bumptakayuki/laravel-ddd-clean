<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain;

use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\OptionId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchPrice;

class BoxLunchOption
{
    public function __construct(
        public readonly OptionId $optionId,
        public readonly BoxLunchId $boxLunchId,
        public readonly string $name,
        public readonly BoxLunchPrice $priceDelta,
        public readonly bool $isRequired
    ) {}
}



