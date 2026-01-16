<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\ListBoxLunches;

class ListBoxLunchesInputData
{
    public function __construct(
        public readonly string $storeId
    ) {}
}


