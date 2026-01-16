<?php
namespace Packages\BoxLunchContext\BoxLunch\UseCase\GetBoxLunchDetail;

class GetBoxLunchDetailInputData
{
    public function __construct(
        public readonly string $boxLunchId
    ) {}
}


