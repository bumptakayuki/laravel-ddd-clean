<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FavoriteEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $favorites = DB::table('favorites')->get();
        $stores = DB::table('stores')->where('is_open', true)->get();
        $boxLunches = DB::table('box_lunches')->where('is_active', true)->get();

        if ($favorites->isEmpty() || ($stores->isEmpty() && $boxLunches->isEmpty())) {
            return;
        }

        $entries = [];

        foreach ($favorites as $favorite) {
            // 各お気に入りリストに1-3個のエントリを追加
            $entryCount = rand(1, 3);

            for ($i = 0; $i < $entryCount; $i++) {
                $targetType = rand(0, 1) === 0 ? 'Store' : 'BoxLunch';

                if ($targetType === 'Store' && !$stores->isEmpty()) {
                    $store = $stores->random();
                    $entries[] = [
                        'entry_id' => 'entry-' . Str::uuid(),
                        'favorite_id' => $favorite->favorite_id,
                        'target_type' => 'Store',
                        'target_id' => $store->store_id,
                        'created_at' => $favorite->created_at,
                        'updated_at' => $favorite->updated_at,
                    ];
                } elseif ($targetType === 'BoxLunch' && !$boxLunches->isEmpty()) {
                    $boxLunch = $boxLunches->random();
                    $entries[] = [
                        'entry_id' => 'entry-' . Str::uuid(),
                        'favorite_id' => $favorite->favorite_id,
                        'target_type' => 'BoxLunch',
                        'target_id' => $boxLunch->box_lunch_id,
                        'created_at' => $favorite->created_at,
                        'updated_at' => $favorite->updated_at,
                    ];
                }
            }
        }

        if (!empty($entries)) {
            DB::table('favorite_entries')->insert($entries);
        }
    }
}



