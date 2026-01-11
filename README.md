# Laravel DDD クリーンアーキテクチャ サンプル

## 概要

このサンプルは、Laravelでクリーンアーキテクチャの実装をしたものです。

## ローカル開発環境のセットアップ

### 前提条件

- Docker と Docker Compose がインストールされていること

### セットアップ手順

1. **環境変数ファイルの作成**

```bash
cp .env.example .env
```

`.env.example`が存在しない場合は、以下の内容で`.env`ファイルを作成してください：

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Tokyo
APP_URL=http://localhost

APP_LOCALE=ja
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=ja_JP

DB_CONNECTION=mysql
DB_HOST=l11sample-mysql
DB_PORT=3306
DB_DATABASE=l11sample
DB_USERNAME=root
DB_PASSWORD=root

REDIS_CLIENT=phpredis
REDIS_HOST=l11sample-redis
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
```

2. **必要なディレクトリの作成**

Laravelが正常に動作するために、以下のディレクトリが必要です：

```bash
# bootstrap/cacheディレクトリの作成
mkdir -p bootstrap/cache
chmod 775 bootstrap/cache

# storageディレクトリの作成（存在しない場合）
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage
```

3. **Dockerコンテナのビルドと起動**

```bash
docker-compose up -d --build
```

4. **依存関係のインストール**

**重要**: Artisanコマンドを実行する前に、必ずComposerの依存関係をインストールしてください。

```bash
# Composerパッケージのインストール
docker-compose exec l11sample-app composer install

# npmパッケージのインストール
docker-compose exec l11sample-app npm install
```

5. **アプリケーションキーの生成**

```bash
docker-compose exec l11sample-app php artisan key:generate
```

6. **データベースのマイグレーション**

```bash
docker-compose exec l11sample-app php artisan migrate
```

7. **シーダーの実行（オプション）**

```bash
docker-compose exec l11sample-app php artisan db:seed
```

### アプリケーションへのアクセス

- **Webアプリケーション**: http://localhost
- **MySQL**: localhost:3306
- **Redis**: localhost:16379
- **Vite Dev Server**: localhost:5173

### よく使うコマンド

```bash
# コンテナの起動
docker-compose up -d

# コンテナの停止
docker-compose down

# ログの確認
docker-compose logs -f

# Artisanコマンドの実行
docker-compose exec l11sample-app php artisan [コマンド]

# Composerコマンドの実行
docker-compose exec l11sample-app composer [コマンド]

# npmコマンドの実行
docker-compose exec l11sample-app npm [コマンド]

# コンテナ内でシェルを開く
docker-compose exec l11sample-app bash
```

## データベースセットアップ

**注意**: マイグレーションやSeederを実行する前に、必ずComposerの依存関係がインストールされていることを確認してください（`docker-compose exec l11sample-app composer install`）。

### マイグレーションの実行

データベーステーブルを作成するには、以下のコマンドを実行してください：

```bash
docker-compose exec l11sample-app php artisan migrate
```

すべてのマイグレーションを実行すると、以下のテーブルが作成されます：

- **Box Lunch Context (Core)**
  - `box_lunches` - 弁当マスタ
  - `box_lunch_options` - 弁当オプション
  - `box_lunch_configurations` - 弁当構成
  - `option_selections` - オプション選択

- **Store / Area Context (Supporting / Generic)**
  - `stores` - 店舗マスタ
  - `areas` - エリアマスタ
  - `store_box_lunches` - 店舗別弁当提供
  - `store_areas` - 店舗別配達エリア

- **Order Context (Supporting)**
  - `orders` - 注文
  - `order_items` - 注文明細
  - `payments` - 決済
  - `acceptances` - 受注
  - `purchases` - 購入

- **Member Context (Generic)**
  - `members` - 会員

- **Favorite Context (Generic)**
  - `favorites` - お気に入り
  - `favorite_entries` - お気に入りエントリ

- **Order History Context (Read Model)**
  - `order_histories` - 注文履歴
  - `order_history_entries` - 注文履歴明細

### Seederの実行

初期データを投入するには、以下のコマンドを実行してください：

```bash
docker-compose exec l11sample-app php artisan db:seed
```

または、`DatabaseSeeder`を明示的に指定：

```bash
docker-compose exec l11sample-app php artisan db:seed --class=DatabaseSeeder
```

`DatabaseSeeder`は依存関係を考慮して、以下の順序でSeederを実行します：

1. `MembersSeeder` - 会員データ
2. `BoxLunchesSeeder` - 弁当マスタ
3. `StoresSeeder` - 店舗マスタ
4. `AreasSeeder` - エリアマスタ
5. `BoxLunchOptionsSeeder` - 弁当オプション
6. `BoxLunchConfigurationsSeeder` - 弁当構成
7. `OptionSelectionsSeeder` - オプション選択
8. `StoreBoxLunchesSeeder` - 店舗別弁当提供
9. `StoreAreasSeeder` - 店舗別配達エリア
10. `OrdersSeeder` - 注文データ
11. `OrderItemsSeeder` - 注文明細
12. `PaymentsSeeder` - 決済データ
13. `AcceptancesSeeder` - 受注データ
14. `PurchasesSeeder` - 購入データ
15. `FavoritesSeeder` - お気に入り
16. `FavoriteEntriesSeeder` - お気に入りエントリ
17. `OrderHistoriesSeeder` - 注文履歴
18. `OrderHistoryEntriesSeeder` - 注文履歴明細

### 特定のSeederのみを実行

特定のSeederのみを実行する場合：

```bash
docker-compose exec l11sample-app php artisan db:seed --class=MembersSeeder
```

### マイグレーションとSeederを同時に実行

データベースをリセットして、マイグレーションとSeederを同時に実行する場合：

```bash
docker-compose exec l11sample-app php artisan migrate:fresh --seed
```

**注意**: `migrate:fresh`は既存のテーブルをすべて削除してから再作成するため、本番環境では使用しないでください。

### マイグレーションのロールバック

最後に実行したマイグレーションをロールバックする場合：

```bash
docker-compose exec l11sample-app php artisan migrate:rollback
```

すべてのマイグレーションをロールバックする場合：

```bash
docker-compose exec l11sample-app php artisan migrate:reset
```
