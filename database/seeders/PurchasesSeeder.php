<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = DB::table('orders')
            ->where('status', 'delivered')
            ->get();

        if ($orders->isEmpty()) {
            return;
        }

        $purchases = [];

        foreach ($orders as $order) {
            $orderedAt = Carbon::parse($order->ordered_at);

            $purchases[] = [
                'purchase_id' => 'purchase-' . Str::uuid(),
                'order_id' => $order->order_id,
                'confirmed_at' => $orderedAt->copy()->addHours(2),
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ];
        }

        if (!empty($purchases)) {
            DB::table('purchases')->insert($purchases);
        }
    }
}

