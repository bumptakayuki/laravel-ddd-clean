<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BoxLunchConfigurationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boxLunches = DB::table('box_lunches')->get();
        $configurations = [];

        foreach ($boxLunches as $boxLunch) {
            // 基本構成（オプションなし）
            $configurations[] = [
                'configuration_id' => 'config-' . Str::uuid(),
                'box_lunch_id' => $boxLunch->box_lunch_id,
                'availability_status' => 'available',
                'total_price' => $boxLunch->base_price,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // オプション付き構成（最初の2つの弁当のみ）
            if (in_array($boxLunch->name, ['幕の内弁当', '唐揚げ弁当'])) {
                $options = DB::table('box_lunch_options')
                    ->where('box_lunch_id', $boxLunch->box_lunch_id)
                    ->where('is_required', false)
                    ->first();

                if ($options) {
                    $configurations[] = [
                        'configuration_id' => 'config-' . Str::uuid(),
                        'box_lunch_id' => $boxLunch->box_lunch_id,
                        'availability_status' => 'available',
                        'total_price' => $boxLunch->base_price + $options->price_delta,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($configurations)) {
            DB::table('box_lunch_configurations')->insert($configurations);
        }
    }
}

