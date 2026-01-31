<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BoxLunchOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 幕の内弁当のオプション
        $boxLunch1 = DB::table('box_lunches')->where('name', '幕の内弁当')->first();
        // 唐揚げ弁当のオプション
        $boxLunch2 = DB::table('box_lunches')->where('name', '唐揚げ弁当')->first();
        // 焼肉弁当のオプション
        $boxLunch3 = DB::table('box_lunches')->where('name', '焼肉弁当')->first();

        $options = [];

        if ($boxLunch1) {
            $options[] = [
                'option_id' => 'option-' . Str::uuid(),
                'box_lunch_id' => $boxLunch1->box_lunch_id,
                'name' => 'ご飯大盛り',
                'price_delta' => 100.00,
                'is_required' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $options[] = [
                'option_id' => 'option-' . Str::uuid(),
                'box_lunch_id' => $boxLunch1->box_lunch_id,
                'name' => 'お味噌汁追加',
                'price_delta' => 50.00,
                'is_required' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($boxLunch2) {
            $options[] = [
                'option_id' => 'option-' . Str::uuid(),
                'box_lunch_id' => $boxLunch2->box_lunch_id,
                'name' => '唐揚げ追加（2個）',
                'price_delta' => 200.00,
                'is_required' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $options[] = [
                'option_id' => 'option-' . Str::uuid(),
                'box_lunch_id' => $boxLunch2->box_lunch_id,
                'name' => 'サイズ選択（大）',
                'price_delta' => 150.00,
                'is_required' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($boxLunch3) {
            $options[] = [
                'option_id' => 'option-' . Str::uuid(),
                'box_lunch_id' => $boxLunch3->box_lunch_id,
                'name' => '焼肉追加',
                'price_delta' => 300.00,
                'is_required' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $options[] = [
                'option_id' => 'option-' . Str::uuid(),
                'box_lunch_id' => $boxLunch3->box_lunch_id,
                'name' => 'サラダ追加',
                'price_delta' => 100.00,
                'is_required' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($options)) {
            DB::table('box_lunch_options')->insert($options);
        }
    }
}



