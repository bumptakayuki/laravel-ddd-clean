<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = DB::table('members')->where('status', 'active')->get();
        $stores = DB::table('stores')->where('is_open', true)->get();

        if ($members->isEmpty() || $stores->isEmpty()) {
            return;
        }

        $orders = [
            [
                'order_id' => 'order-' . Str::uuid(),
                'member_id' => $members->first()->member_id,
                'store_id' => $stores->first()->store_id,
                'status' => 'confirmed',
                'total_amount' => 1850.00,
                'ordered_at' => now()->subDays(5),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'order_id' => 'order-' . Str::uuid(),
                'member_id' => $members->skip(1)->first()->member_id ?? $members->first()->member_id,
                'store_id' => $stores->skip(1)->first()->store_id ?? $stores->first()->store_id,
                'status' => 'preparing',
                'total_amount' => 1560.00,
                'ordered_at' => now()->subDays(2),
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'order_id' => 'order-' . Str::uuid(),
                'member_id' => $members->first()->member_id,
                'store_id' => $stores->first()->store_id,
                'status' => 'delivered',
                'total_amount' => 1960.00,
                'ordered_at' => now()->subDays(10),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'order_id' => 'order-' . Str::uuid(),
                'member_id' => $members->skip(2)->first()->member_id ?? $members->first()->member_id,
                'store_id' => $stores->first()->store_id,
                'status' => 'pending',
                'total_amount' => 1440.00,
                'ordered_at' => now()->subHours(2),
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}

