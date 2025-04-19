<?php
namespace Packages\Order\Order\UseCase\CreateOrder;

interface ICreateOrderUseCase
{
    public function handle(CreateOrderInputData $input): CreateOrderOutputData;
}
