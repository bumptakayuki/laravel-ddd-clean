<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // ドメインモデル用のSeederを実行
        $this->call([
            MembersSeeder::class,
            BoxLunchesSeeder::class,
            StoresSeeder::class,
            AreasSeeder::class,
            BoxLunchOptionsSeeder::class,
            BoxLunchConfigurationsSeeder::class,
            OptionSelectionsSeeder::class,
            StoreBoxLunchesSeeder::class,
            StoreAreasSeeder::class,
            OrdersSeeder::class,
            OrderItemsSeeder::class,
            PaymentsSeeder::class,
            AcceptancesSeeder::class,
            PurchasesSeeder::class,
            FavoritesSeeder::class,
            FavoriteEntriesSeeder::class,
            OrderHistoriesSeeder::class,
            OrderHistoryEntriesSeeder::class,
        ]);
    }
}
