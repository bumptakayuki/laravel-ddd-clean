<?php
namespace Packages\OrderContext\Order\UseCase\ListOrders;

interface IListOrdersUseCase
{
    public function handle(ListOrdersInputData $input): ListOrdersOutputData;
}

