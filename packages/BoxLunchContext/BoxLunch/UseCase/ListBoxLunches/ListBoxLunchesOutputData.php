<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\ListBoxLunches;

class ListBoxLunchesOutputData
{
    /**
     * @param array<int, array<string, mixed>> $boxLunches
     */
    public function __construct(
        public readonly array $boxLunches
    ) {}
}


