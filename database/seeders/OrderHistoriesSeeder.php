<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderHistoriesSeeder extends Seeder
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

        $histories = [];

        foreach ($members as $member) {
            // 各会員に1-2個の注文履歴を作成
            $historyCount = rand(1, 2);

            for ($i = 0; $i < $historyCount; $i++) {
                $histories[] = [
                    'history_id' => 'history-' . Str::uuid(),
                    'member_id' => $member->member_id,
                    'generated_at' => now()->subDays(rand(1, 30)),
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(1, 30)),
                ];
            }
        }

        if (!empty($histories)) {
            DB::table('order_histories')->insert($histories);
        }
    }
}



