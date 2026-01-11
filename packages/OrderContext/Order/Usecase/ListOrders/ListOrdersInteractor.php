<?php
namespace Packages\OrderContext\Order\UseCase\ListOrders;

use Packages\OrderContext\Order\Domain\Repository\OrderRepositoryInterface;

class ListOrdersInteractor implements IListOrdersUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {}
    
    public function handle(ListOrdersInputData $input): ListOrdersOutputData
    {
        $orders = $this->orderRepository->findByMemberId($input->memberId);
        
        $ordersArray = [];
        foreach ($orders as $order) {
            $itemsArray = [];
            foreach ($order->items as $item) {
                $itemsArray[] = [
                    'order_item_id' => $item->orderItemId->getValue(),
                    'configuration_id' => $item->configurationId,
                    'unit_price' => $item->unitPrice->getValue(),
                    'quantity' => $item->quantity,
                    'line_amount' => $item->lineAmount->getValue(),
                ];
            }
            
            $ordersArray[] = [
                'order_id' => $order->orderId->getValue(),
                'member_id' => $order->memberId,
                'store_id' => $order->storeId,
                'status' => $order->status->getValue(),
                'total_amount' => $order->totalAmount->getValue(),
                'ordered_at' => $order->orderedAt->format('Y-m-d H:i:s'),
                'items' => $itemsArray,
            ];
        }
        
        return new ListOrdersOutputData($ordersArray);
    }
}

