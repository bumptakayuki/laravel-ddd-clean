<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = DB::table('orders')
            ->whereIn('status', ['confirmed', 'preparing', 'delivered'])
            ->get();

        if ($orders->isEmpty()) {
            return;
        }

        $payments = [];

        foreach ($orders as $order) {
            $status = match ($order->status) {
                'delivered' => 'completed',
                'preparing' => 'completed',
                'confirmed' => 'completed',
                default => 'pending',
            };

            $orderedAt = Carbon::parse($order->ordered_at);

            $payments[] = [
                'payment_id' => 'payment-' . Str::uuid(),
                'order_id' => $order->order_id,
                'method' => ['credit_card', 'bank_transfer', 'e_money'][array_rand(['credit_card', 'bank_transfer', 'e_money'])],
                'status' => $status,
                'transaction_id' => 'txn-' . Str::random(16),
                'paid_at' => $status === 'completed' ? $orderedAt->copy()->addMinutes(5) : null,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ];
        }

        if (!empty($payments)) {
            DB::table('payments')->insert($payments);
        }
    }
}

