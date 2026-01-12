<?php
namespace Packages\AreaContext\Area\UseCase\GetArea;

class GetAreaOutputData
{
    /**
     * @param array<string, mixed>|null $area
     */
    public function __construct(
        public readonly ?array $area
    ) {}
}

