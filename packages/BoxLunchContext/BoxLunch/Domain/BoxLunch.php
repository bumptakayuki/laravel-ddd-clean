<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain;

use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchId;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchName;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\BoxLunchPrice;

class BoxLunch
{
    /**
     * @param BoxLunchOption[] $options
     */
    public function __construct(
        public readonly BoxLunchId $boxLunchId,
        public readonly BoxLunchName $name,
        public readonly string $description,
        public readonly BoxLunchPrice $basePrice,
        public readonly bool $isActive,
        public readonly array $options = []
    ) {}
}


