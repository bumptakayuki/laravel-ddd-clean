<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreBoxLunchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = DB::table('stores')->get();
        $boxLunches = DB::table('box_lunches')->get();

        $storeBoxLunches = [];

        foreach ($stores as $store) {
            foreach ($boxLunches as $boxLunch) {
                // 各店舗がすべての弁当を提供可能とする
                $storeBoxLunches[] = [
                    'store_id' => $store->store_id,
                    'box_lunch_id' => $boxLunch->box_lunch_id,
                    'is_available' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($storeBoxLunches)) {
            DB::table('store_box_lunches')->insert($storeBoxLunches);
        }
    }
}

