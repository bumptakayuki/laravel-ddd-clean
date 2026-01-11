<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AcceptancesSeeder extends Seeder
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

        $acceptances = [];

        foreach ($orders as $order) {
            $orderedAt = Carbon::parse($order->ordered_at);

            $acceptances[] = [
                'acceptance_id' => 'acceptance-' . Str::uuid(),
                'order_id' => $order->order_id,
                'accepted_at' => $orderedAt->copy()->addMinutes(10),
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ];
        }

        if (!empty($acceptances)) {
            DB::table('acceptances')->insert($acceptances);
        }
    }
}

