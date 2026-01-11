<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            [
                'store_id' => 'store-' . Str::uuid(),
                'name' => '弁当屋 本店',
                'address' => '東京都千代田区丸の内1-1-1',
                'is_open' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 'store-' . Str::uuid(),
                'name' => '弁当屋 新宿店',
                'address' => '東京都新宿区新宿3-1-1',
                'is_open' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 'store-' . Str::uuid(),
                'name' => '弁当屋 渋谷店',
                'address' => '東京都渋谷区渋谷2-2-2',
                'is_open' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 'store-' . Str::uuid(),
                'name' => '弁当屋 池袋店',
                'address' => '東京都豊島区池袋1-1-1',
                'is_open' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => 'store-' . Str::uuid(),
                'name' => '弁当屋 横浜店',
                'address' => '神奈川県横浜市西区みなとみらい1-1-1',
                'is_open' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('stores')->insert($stores);
    }
}

