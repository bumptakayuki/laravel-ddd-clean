<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            [
                'area_id' => 'area-' . Str::uuid(),
                'name' => '千代田区',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => 'area-' . Str::uuid(),
                'name' => '新宿区',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => 'area-' . Str::uuid(),
                'name' => '渋谷区',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => 'area-' . Str::uuid(),
                'name' => '豊島区',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => 'area-' . Str::uuid(),
                'name' => '横浜市西区',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => 'area-' . Str::uuid(),
                'name' => '港区',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('areas')->insert($areas);
    }
}



