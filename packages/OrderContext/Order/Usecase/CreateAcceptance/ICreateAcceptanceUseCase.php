<?php
namespace Packages\OrderContext\Order\UseCase\CreateAcceptance;

interface ICreateAcceptanceUseCase
{
    public function handle(CreateAcceptanceInputData $input): CreateAcceptanceOutputData;
}

