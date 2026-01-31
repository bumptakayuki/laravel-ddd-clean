<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderHistoryEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $histories = DB::table('order_histories')->get();
        $orders = DB::table('orders')
            ->join('stores', 'orders.store_id', '=', 'stores.store_id')
            ->select('orders.*', 'stores.name as store_name')
            ->get();

        if ($histories->isEmpty() || $orders->isEmpty()) {
            return;
        }

        $entries = [];

        foreach ($histories as $history) {
            // 各履歴に1-3個の履歴明細を追加
            $entryCount = rand(1, 3);
            $memberOrders = $orders->where('member_id', $history->member_id);

            if ($memberOrders->isEmpty()) {
                continue;
            }

            $selectedOrders = $memberOrders->random(min($entryCount, $memberOrders->count()));

            foreach ($selectedOrders as $order) {
                $entries[] = [
                    'entry_id' => 'historyentry-' . Str::uuid(),
                    'history_id' => $history->history_id,
                    'order_id' => $order->order_id,
                    'store_name' => $order->store_name,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'occurred_at' => $order->ordered_at,
                    'created_at' => $history->created_at,
                    'updated_at' => $history->updated_at,
                ];
            }
        }

        if (!empty($entries)) {
            DB::table('order_history_entries')->insert($entries);
        }
    }
}



