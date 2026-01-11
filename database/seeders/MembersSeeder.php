<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'member_id' => 'member-001',
                'email' => 'test@example.com',
                'name' => 'テストユーザー',
                'status' => 'active',
                'registered_at' => now()->subMonths(6),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => 'member-' . Str::uuid(),
                'email' => 'tanaka@example.com',
                'name' => '田中太郎',
                'status' => 'active',
                'registered_at' => now()->subMonths(6),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => 'member-' . Str::uuid(),
                'email' => 'suzuki@example.com',
                'name' => '鈴木花子',
                'status' => 'active',
                'registered_at' => now()->subMonths(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => 'member-' . Str::uuid(),
                'email' => 'yamada@example.com',
                'name' => '山田次郎',
                'status' => 'active',
                'registered_at' => now()->subMonths(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => 'member-' . Str::uuid(),
                'email' => 'watanabe@example.com',
                'name' => '渡辺三郎',
                'status' => 'inactive',
                'registered_at' => now()->subMonths(12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => 'member-' . Str::uuid(),
                'email' => 'ito@example.com',
                'name' => '伊藤美咲',
                'status' => 'active',
                'registered_at' => now()->subDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // member-001が存在しない場合のみ挿入
        foreach ($members as $member) {
            DB::table('members')->updateOrInsert(
                ['member_id' => $member['member_id']],
                $member
            );
        }
    }
}

