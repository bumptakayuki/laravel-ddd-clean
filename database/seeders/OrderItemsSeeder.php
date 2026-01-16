<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = DB::table('orders')->get();
        $configurations = DB::table('box_lunch_configurations')
            ->where('availability_status', 'available')
            ->get();

        if ($orders->isEmpty() || $configurations->isEmpty()) {
            return;
        }

        $orderItems = [];

        foreach ($orders as $index => $order) {
            // 各注文に1-2個の明細を追加
            $itemCount = ($index % 2) + 1;

            for ($i = 0; $i < $itemCount; $i++) {
                $config = $configurations->random();
                $quantity = ($i === 0) ? 2 : 1;
                $unitPrice = $config->total_price;
                $lineAmount = $unitPrice * $quantity;

                $orderItems[] = [
                    'order_item_id' => 'orderitem-' . Str::uuid(),
                    'order_id' => $order->order_id,
                    'configuration_id' => $config->configuration_id,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'line_amount' => $lineAmount,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ];
            }
        }

        if (!empty($orderItems)) {
            DB::table('order_items')->insert($orderItems);
        }
    }
}


