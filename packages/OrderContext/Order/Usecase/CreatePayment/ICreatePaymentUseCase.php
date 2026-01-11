<?php
namespace Packages\OrderContext\Order\UseCase\CreatePayment;

interface ICreatePaymentUseCase
{
    public function handle(CreatePaymentInputData $input): CreatePaymentOutputData;
}

