<?php
namespace Packages\OrderContext\Order\UseCase\CreateOrder;

interface ICreateOrderUseCase
{
    public function handle(CreateOrderInputData $input): CreateOrderOutputData;
}

