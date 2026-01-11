<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\GetBoxLunchDetail;

class GetBoxLunchDetailOutputData
{
    /**
     * @param array<string, mixed> $boxLunch
     */
    public function __construct(
        public readonly array $boxLunch
    ) {}
}

