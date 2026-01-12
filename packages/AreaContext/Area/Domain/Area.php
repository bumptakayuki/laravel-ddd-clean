<?php
namespace Packages\AreaContext\Area\Domain;

use Packages\AreaContext\Area\Domain\ValueObject\AreaId;
use Packages\AreaContext\Area\Domain\ValueObject\AreaName;

class Area
{
    public function __construct(
        public readonly AreaId $areaId,
        public readonly AreaName $name
    ) {}
}

