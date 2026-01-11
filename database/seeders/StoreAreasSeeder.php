<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = DB::table('stores')->get();
        $areas = DB::table('areas')->get();

        $storeAreas = [];

        // 店舗名とエリア名のマッピング
        $storeAreaMap = [
            '弁当屋 本店' => ['千代田区', '港区'],
            '弁当屋 新宿店' => ['新宿区', '渋谷区'],
            '弁当屋 渋谷店' => ['渋谷区', '港区'],
            '弁当屋 池袋店' => ['豊島区'],
            '弁当屋 横浜店' => ['横浜市西区'],
        ];

        foreach ($stores as $store) {
            $areaNames = $storeAreaMap[$store->name] ?? [];

            foreach ($areas as $area) {
                if (in_array($area->name, $areaNames)) {
                    $storeAreas[] = [
                        'store_id' => $store->store_id,
                        'area_id' => $area->area_id,
                        'is_deliverable' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($storeAreas)) {
            DB::table('store_areas')->insert($storeAreas);
        }
    }
}

