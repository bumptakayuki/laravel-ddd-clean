<?php
namespace Packages\Order\Order\UseCase\CreateOrder;

use Packages\Order\Order\Domain\Repository\OrderRepositoryInterface;
use Packages\Order\Order\Domain\ValueObject\OrderId;
use Packages\Order\Order\Domain\ValueObject\OrderStatus;
use Packages\Order\Order\Domain\ValueObject\OrderItem;
use Packages\Order\Order\Domain\Entity\Order;

class CreateOrderInteractor implements ICreateOrderUseCase
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository
    ) {}

    public function handle(CreateOrderInputData $input): void
    {
        $id = new OrderId();
        $status = new OrderStatus($input->status);
        $items = array_map(
            fn(array $item) => new OrderItem($item['product_id'], $item['quantity']),
            $input->items
        );

        $order = new Order($id, $status, $items);
        $this->orderRepository->save($order);
    }
}
