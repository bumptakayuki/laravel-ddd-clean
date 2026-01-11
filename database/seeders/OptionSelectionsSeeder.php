<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSelectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // オプション付きの構成に対してオプション選択を追加
        // まずすべての構成を取得し、後でフィルタリング
        $allConfigurations = DB::table('box_lunch_configurations')->get();
        $boxLunches = DB::table('box_lunches')->get()->keyBy('box_lunch_id');

        $configurations = $allConfigurations->filter(function ($config) use ($boxLunches) {
            $boxLunch = $boxLunches->get($config->box_lunch_id);
            return $boxLunch && $config->total_price > $boxLunch->base_price;
        });

        $selections = [];

        foreach ($configurations as $config) {
            $boxLunch = DB::table('box_lunches')
                ->where('box_lunch_id', $config->box_lunch_id)
                ->first();

            if (!$boxLunch) {
                continue;
            }

            // この構成に含まれるオプションを取得
            $options = DB::table('box_lunch_options')
                ->where('box_lunch_id', $config->box_lunch_id)
                ->where('is_required', false)
                ->get();

            foreach ($options as $option) {
                // 価格差分が一致するオプションを選択
                $priceDelta = $config->total_price - $boxLunch->base_price;
                if ($option->price_delta <= $priceDelta) {
                    $selections[] = [
                        'selection_id' => 'selection-' . uniqid(),
                        'configuration_id' => $config->configuration_id,
                        'option_id' => $option->option_id,
                        'quantity' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    break; // 最初の一致するオプションのみ
                }
            }
        }

        if (!empty($selections)) {
            DB::table('option_selections')->insert($selections);
        }
    }
}

