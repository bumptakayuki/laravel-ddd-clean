<?php
namespace Packages\AreaContext\Area\UseCase\ListAreas;

class ListAreasOutputData
{
    /**
     * @param array<int, array<string, mixed>> $areas
     */
    public function __construct(
        public readonly array $areas
    ) {}
}



