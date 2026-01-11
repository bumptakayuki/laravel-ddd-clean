<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BoxLunchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boxLunches = [
            [
                'box_lunch_id' => 'boxlunch-' . Str::uuid(),
                'name' => '幕の内弁当',
                'description' => '定番の幕の内弁当。ご飯、焼き魚、卵焼き、煮物などが入ったバランスの良いお弁当です。',
                'base_price' => 850.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'box_lunch_id' => 'boxlunch-' . Str::uuid(),
                'name' => '唐揚げ弁当',
                'description' => 'ジューシーな唐揚げがメインのお弁当。サクサクの衣とジューシーな肉質が自慢です。',
                'base_price' => 780.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'box_lunch_id' => 'boxlunch-' . Str::uuid(),
                'name' => '焼肉弁当',
                'description' => '特製タレで味付けした焼肉がたっぷり入ったボリューム満点のお弁当です。',
                'base_price' => 980.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'box_lunch_id' => 'boxlunch-' . Str::uuid(),
                'name' => 'サラダチキン弁当',
                'description' => 'ヘルシーなサラダチキンがメインの健康志向のお弁当です。',
                'base_price' => 720.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'box_lunch_id' => 'boxlunch-' . Str::uuid(),
                'name' => 'エビフライ弁当',
                'description' => 'プリプリのエビフライが3本入ったお弁当。タルタルソース付きです。',
                'base_price' => 920.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('box_lunches')->insert($boxLunches);
    }
}

