<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FavoritesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = DB::table('members')->where('status', 'active')->get();

        if ($members->isEmpty()) {
            return;
        }

        $favorites = [];

        foreach ($members as $member) {
            // 各会員に1-2個のお気に入りリストを作成
            $favoriteCount = (rand(1, 2));

            for ($i = 0; $i < $favoriteCount; $i++) {
                $favorites[] = [
                    'favorite_id' => 'favorite-' . Str::uuid(),
                    'member_id' => $member->member_id,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(1, 30)),
                ];
            }
        }

        if (!empty($favorites)) {
            DB::table('favorites')->insert($favorites);
        }
    }
}

