# データベース設計書

## 概要

本ドキュメントは、弁当販売サイトのデータベース設計書です。ドメイン駆動設計（DDD）に基づいて設計されています。

## 目次

1. [テーブル一覧](#テーブル一覧)
2. [テーブル定義](#テーブル定義)
   - [Box Lunch Context (Core)](#box-lunch-context-core)
   - [Store / Area Context (Supporting / Generic)](#store--area-context-supporting--generic)
   - [Order Context (Supporting)](#order-context-supporting)
   - [Member Context (Generic)](#member-context-generic)
   - [Favorite Context (Generic)](#favorite-context-generic)
   - [Order History Context (Read Model)](#order-history-context-read-model)
3. [リレーションシップ](#リレーションシップ)
4. [インデックス設計](#インデックス設計)

---

## テーブル一覧

### Box Lunch Context (Core)
- `box_lunches` - 弁当マスタ
- `box_lunch_options` - 弁当オプション
- `box_lunch_configurations` - 弁当構成
- `option_selections` - オプション選択

### Store / Area Context (Supporting / Generic)
- `stores` - 店舗マスタ
- `areas` - エリアマスタ
- `store_box_lunches` - 店舗別弁当提供
- `store_areas` - 店舗別配達エリア

### Order Context (Supporting)
- `orders` - 注文
- `order_items` - 注文明細
- `payments` - 決済
- `acceptances` - 受注
- `purchases` - 購入

### Member Context (Generic)
- `members` - 会員

### Favorite Context (Generic)
- `favorites` - お気に入り
- `favorite_entries` - お気に入りエントリ

### Order History Context (Read Model)
- `order_histories` - 注文履歴
- `order_history_entries` - 注文履歴明細

---

## テーブル定義

### Box Lunch Context (Core)

#### box_lunches

弁当マスタテーブル。販売される弁当の基本情報を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| box_lunch_id | VARCHAR(255) | PRIMARY KEY | 弁当ID |
| name | VARCHAR(255) | NOT NULL | 弁当名 |
| description | TEXT | NULL | 説明 |
| base_price | DECIMAL(10,2) | NOT NULL | 基本価格 |
| is_active | BOOLEAN | NOT NULL DEFAULT TRUE | 販売中フラグ |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |
| deleted_at | TIMESTAMP | NULL | 削除日時（ソフトデリート用） |

**インデックス:**
- PRIMARY KEY: `box_lunch_id`
- INDEX: `is_active`

---

#### box_lunch_options

弁当オプションテーブル。各弁当に設定可能なオプション（サイズ、トッピングなど）を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| option_id | VARCHAR(255) | PRIMARY KEY | オプションID |
| box_lunch_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 弁当ID |
| name | VARCHAR(255) | NOT NULL | オプション名 |
| price_delta | DECIMAL(10,2) | NOT NULL DEFAULT 0 | 価格差分 |
| is_required | BOOLEAN | NOT NULL DEFAULT FALSE | 必須フラグ |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |
| deleted_at | TIMESTAMP | NULL | 削除日時（ソフトデリート用） |

**インデックス:**
- PRIMARY KEY: `option_id`
- FOREIGN KEY: `box_lunch_id` → `box_lunches.box_lunch_id`
- INDEX: `box_lunch_id`

---

#### box_lunch_configurations

弁当構成テーブル。オプションを選択した弁当の構成を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| configuration_id | VARCHAR(255) | PRIMARY KEY | 構成ID |
| box_lunch_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 弁当ID |
| availability_status | VARCHAR(50) | NOT NULL | 提供可否状態 |
| total_price | DECIMAL(10,2) | NOT NULL | 合計金額 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |
| deleted_at | TIMESTAMP | NULL | 削除日時（ソフトデリート用） |

**インデックス:**
- PRIMARY KEY: `configuration_id`
- FOREIGN KEY: `box_lunch_id` → `box_lunches.box_lunch_id`
- INDEX: `box_lunch_id`
- INDEX: `availability_status`

**補足:**
- `availability_status` の値例: `available`, `unavailable`, `sold_out`

---

#### option_selections

オプション選択テーブル。弁当構成に含まれるオプションの選択内容を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| selection_id | VARCHAR(255) | PRIMARY KEY | 選択ID |
| configuration_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 構成ID |
| option_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | オプションID |
| quantity | INTEGER | NOT NULL DEFAULT 1 | 数量 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `selection_id`
- FOREIGN KEY: `configuration_id` → `box_lunch_configurations.configuration_id`
- FOREIGN KEY: `option_id` → `box_lunch_options.option_id`
- INDEX: `configuration_id`
- INDEX: `option_id`
- UNIQUE: `(configuration_id, option_id)` - 同一構成内で同じオプションは1つのみ

---

### Store / Area Context (Supporting / Generic)

#### stores

店舗マスタテーブル。弁当を提供する店舗の情報を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| store_id | VARCHAR(255) | PRIMARY KEY | 店舗ID |
| name | VARCHAR(255) | NOT NULL | 店舗名 |
| address | VARCHAR(500) | NOT NULL | 住所 |
| is_open | BOOLEAN | NOT NULL DEFAULT TRUE | 営業中フラグ |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |
| deleted_at | TIMESTAMP | NULL | 削除日時（ソフトデリート用） |

**インデックス:**
- PRIMARY KEY: `store_id`
- INDEX: `is_open`

---

#### areas

エリアマスタテーブル。配達可能なエリアの情報を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| area_id | VARCHAR(255) | PRIMARY KEY | エリアID |
| name | VARCHAR(255) | NOT NULL | エリア名 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |
| deleted_at | TIMESTAMP | NULL | 削除日時（ソフトデリート用） |

**インデックス:**
- PRIMARY KEY: `area_id`

---

#### store_box_lunches

店舗別弁当提供テーブル。各店舗が提供可能な弁当を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| store_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 店舗ID |
| box_lunch_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 弁当ID |
| is_available | BOOLEAN | NOT NULL DEFAULT TRUE | 提供可フラグ |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `(store_id, box_lunch_id)`
- FOREIGN KEY: `store_id` → `stores.store_id`
- FOREIGN KEY: `box_lunch_id` → `box_lunches.box_lunch_id`
- INDEX: `is_available`

---

#### store_areas

店舗別配達エリアテーブル。各店舗が配達可能なエリアを管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| store_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 店舗ID |
| area_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | エリアID |
| is_deliverable | BOOLEAN | NOT NULL DEFAULT TRUE | 配達可フラグ |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `(store_id, area_id)`
- FOREIGN KEY: `store_id` → `stores.store_id`
- FOREIGN KEY: `area_id` → `areas.area_id`
- INDEX: `is_deliverable`

---

### Order Context (Supporting)

#### orders

注文テーブル。会員による注文情報を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| order_id | VARCHAR(255) | PRIMARY KEY | 注文ID |
| member_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 会員ID |
| store_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 店舗ID |
| status | VARCHAR(50) | NOT NULL | 注文状態 |
| total_amount | DECIMAL(10,2) | NOT NULL | 注文合計 |
| ordered_at | TIMESTAMP | NOT NULL | 注文日時 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `order_id`
- FOREIGN KEY: `member_id` → `members.member_id`
- FOREIGN KEY: `store_id` → `stores.store_id`
- INDEX: `member_id`
- INDEX: `store_id`
- INDEX: `status`
- INDEX: `ordered_at`

**補足:**
- `status` の値例: `pending`, `confirmed`, `preparing`, `ready`, `delivered`, `cancelled`

---

#### order_items

注文明細テーブル。注文に含まれる各弁当構成の明細を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| order_item_id | VARCHAR(255) | PRIMARY KEY | 注文明細ID |
| order_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 注文ID |
| configuration_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 構成ID |
| unit_price | DECIMAL(10,2) | NOT NULL | 単価 |
| quantity | INTEGER | NOT NULL | 数量 |
| line_amount | DECIMAL(10,2) | NOT NULL | 小計 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `order_item_id`
- FOREIGN KEY: `order_id` → `orders.order_id`
- FOREIGN KEY: `configuration_id` → `box_lunch_configurations.configuration_id`
- INDEX: `order_id`
- INDEX: `configuration_id`

---

#### payments

決済テーブル。注文に対する決済情報を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| payment_id | VARCHAR(255) | PRIMARY KEY | 決済ID |
| order_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 注文ID |
| method | VARCHAR(50) | NOT NULL | 決済手段 |
| status | VARCHAR(50) | NOT NULL | 決済状態 |
| transaction_id | VARCHAR(255) | NULL | 取引ID |
| paid_at | TIMESTAMP | NULL | 決済日時 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `payment_id`
- FOREIGN KEY: `order_id` → `orders.order_id`
- INDEX: `order_id`
- INDEX: `status`
- INDEX: `transaction_id`

**補足:**
- `method` の値例: `credit_card`, `bank_transfer`, `cash_on_delivery`, `e_money`
- `status` の値例: `pending`, `processing`, `completed`, `failed`, `refunded`

---

#### acceptances

受注テーブル。店舗による注文の受注情報を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| acceptance_id | VARCHAR(255) | PRIMARY KEY | 受注ID |
| order_id | VARCHAR(255) | NOT NULL, FOREIGN KEY, UNIQUE | 注文ID |
| accepted_at | TIMESTAMP | NOT NULL | 受注日時 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `acceptance_id`
- FOREIGN KEY: `order_id` → `orders.order_id`
- UNIQUE: `order_id` - 1注文につき1つの受注のみ

---

#### purchases

購入テーブル。注文の購入確定情報を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| purchase_id | VARCHAR(255) | PRIMARY KEY | 購入ID |
| order_id | VARCHAR(255) | NOT NULL, FOREIGN KEY, UNIQUE | 注文ID |
| confirmed_at | TIMESTAMP | NOT NULL | 購入確定日時 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `purchase_id`
- FOREIGN KEY: `order_id` → `orders.order_id`
- UNIQUE: `order_id` - 1注文につき1つの購入のみ

---

### Member Context (Generic)

#### members

会員マスタテーブル。システムに登録されている会員の情報を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| member_id | VARCHAR(255) | PRIMARY KEY | 会員ID |
| email | VARCHAR(255) | NOT NULL, UNIQUE | メールアドレス |
| name | VARCHAR(255) | NOT NULL | 氏名 |
| status | VARCHAR(50) | NOT NULL | 会員状態 |
| registered_at | TIMESTAMP | NOT NULL | 登録日時 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |
| deleted_at | TIMESTAMP | NULL | 削除日時（ソフトデリート用） |

**インデックス:**
- PRIMARY KEY: `member_id`
- UNIQUE: `email`
- INDEX: `status`

**補足:**
- `status` の値例: `active`, `inactive`, `suspended`, `deleted`

---

### Favorite Context (Generic)

#### favorites

お気に入りテーブル。会員のお気に入りコレクションを管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| favorite_id | VARCHAR(255) | PRIMARY KEY | お気に入りID |
| member_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 会員ID |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `favorite_id`
- FOREIGN KEY: `member_id` → `members.member_id`
- INDEX: `member_id`

---

#### favorite_entries

お気に入りエントリテーブル。お気に入りに含まれる個別のアイテム（店舗または弁当）を管理します。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| entry_id | VARCHAR(255) | PRIMARY KEY | エントリID |
| favorite_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | お気に入りID |
| target_type | VARCHAR(50) | NOT NULL | 対象種別(Store/BoxLunch) |
| target_id | VARCHAR(255) | NOT NULL | 対象ID |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `entry_id`
- FOREIGN KEY: `favorite_id` → `favorites.favorite_id`
- INDEX: `favorite_id`
- INDEX: `(target_type, target_id)`

**補足:**
- `target_type` の値: `Store`, `BoxLunch`
- `target_id` は `target_type` に応じて `store_id` または `box_lunch_id` を参照

---

### Order History Context (Read Model)

#### order_histories

注文履歴テーブル。会員の注文履歴を管理します（読み取り専用モデル）。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| history_id | VARCHAR(255) | PRIMARY KEY | 履歴ID |
| member_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 会員ID |
| generated_at | TIMESTAMP | NOT NULL | 生成日時 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `history_id`
- FOREIGN KEY: `member_id` → `members.member_id`
- INDEX: `member_id`
- INDEX: `generated_at`

---

#### order_history_entries

注文履歴明細テーブル。注文履歴に含まれる各注文のスナップショット情報を管理します（読み取り専用モデル）。

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| entry_id | VARCHAR(255) | PRIMARY KEY | 履歴明細ID |
| history_id | VARCHAR(255) | NOT NULL, FOREIGN KEY | 履歴ID |
| order_id | VARCHAR(255) | NOT NULL | 注文ID |
| store_name | VARCHAR(255) | NOT NULL | 店舗名(スナップショット) |
| total_amount | DECIMAL(10,2) | NOT NULL | 合計(スナップショット) |
| status | VARCHAR(50) | NOT NULL | 状態(スナップショット) |
| occurred_at | TIMESTAMP | NOT NULL | 発生日時 |
| created_at | TIMESTAMP | NULL | 作成日時 |
| updated_at | TIMESTAMP | NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY: `entry_id`
- FOREIGN KEY: `history_id` → `order_histories.history_id`
- INDEX: `history_id`
- INDEX: `order_id`
- INDEX: `occurred_at`

**補足:**
- このテーブルは読み取り専用モデル（Read Model）であり、注文のスナップショットを保持します
- `store_name`, `total_amount`, `status` は注文時点の値を保持し、元の注文データが変更されても影響を受けません

---

## リレーションシップ

### 主要なリレーションシップ

1. **BOX_LUNCH → BOX_LUNCH_OPTION** (1:N)
   - 1つの弁当に対して複数のオプションが存在

2. **BOX_LUNCH → BOX_LUNCH_CONFIGURATION** (1:N)
   - 1つの弁当に対して複数の構成が存在

3. **BOX_LUNCH_CONFIGURATION → OPTION_SELECTION** (1:N)
   - 1つの構成に対して複数のオプション選択が存在

4. **BOX_LUNCH_OPTION → OPTION_SELECTION** (1:N)
   - 1つのオプションが複数の選択で使用される

5. **STORE ↔ BOX_LUNCH** (N:M via STORE_BOX_LUNCH)
   - 店舗と弁当の多対多関係

6. **STORE ↔ AREA** (N:M via STORE_AREA)
   - 店舗とエリアの多対多関係

7. **MEMBER → ORDER** (1:N)
   - 1人の会員が複数の注文を作成

8. **STORE → ORDER** (1:N)
   - 1つの店舗が複数の注文を受ける

9. **ORDER → ORDER_ITEM** (1:N)
   - 1つの注文に複数の明細が存在

10. **BOX_LUNCH_CONFIGURATION → ORDER_ITEM** (1:N)
    - 1つの構成が複数の注文明細で参照される

11. **ORDER → PAYMENT** (1:0..1)
    - 1つの注文に対して0または1つの決済が存在

12. **ORDER → ACCEPTANCE** (1:0..1)
    - 1つの注文に対して0または1つの受注が存在

13. **ORDER → PURCHASE** (1:0..1)
    - 1つの注文に対して0または1つの購入が存在

14. **MEMBER → FAVORITE** (1:N)
    - 1人の会員が複数のお気に入りリストを持つ

15. **FAVORITE → FAVORITE_ENTRY** (1:N)
    - 1つのお気に入りリストに複数のエントリが存在

16. **MEMBER → ORDER_HISTORY** (1:N)
    - 1人の会員が複数の注文履歴を持つ

17. **ORDER_HISTORY → ORDER_HISTORY_ENTRY** (1:N)
    - 1つの注文履歴に複数の履歴明細が存在

---

## インデックス設計

### 主キーインデックス
すべてのテーブルに主キーインデックスが設定されています。

### 外部キーインデックス
すべての外部キーカラムにインデックスが設定されています。

### 検索用インデックス
以下のカラムに検索用インデックスが設定されています：

- `box_lunches.is_active` - 販売中の弁当を検索
- `box_lunch_configurations.availability_status` - 提供可否状態で検索
- `stores.is_open` - 営業中の店舗を検索
- `store_box_lunches.is_available` - 提供可能な弁当を検索
- `store_areas.is_deliverable` - 配達可能なエリアを検索
- `orders.status` - 注文状態で検索
- `orders.ordered_at` - 注文日時で検索
- `payments.status` - 決済状態で検索
- `payments.transaction_id` - 取引IDで検索
- `members.status` - 会員状態で検索
- `favorite_entries.(target_type, target_id)` - 対象種別とIDで検索
- `order_histories.generated_at` - 生成日時で検索
- `order_history_entries.occurred_at` - 発生日時で検索

### 複合インデックス
- `store_box_lunches.(store_id, box_lunch_id)` - 主キー
- `store_areas.(store_id, area_id)` - 主キー
- `option_selections.(configuration_id, option_id)` - ユニーク制約
- `favorite_entries.(target_type, target_id)` - 検索用

---

## 補足事項

### データ型について
- ID系のカラムは `VARCHAR(255)` を使用（UUIDやカスタムID形式に対応）
- 金額系のカラムは `DECIMAL(10,2)` を使用（精度を保証）
- 日時系のカラムは `TIMESTAMP` を使用
- フラグ系のカラムは `BOOLEAN` を使用

### ソフトデリート
以下のテーブルでソフトデリート（`deleted_at`）を実装：
- `box_lunches`
- `box_lunch_options`
- `box_lunch_configurations`
- `stores`
- `areas`
- `members`

### タイムスタンプ
Laravelの標準に従い、`created_at` と `updated_at` を全テーブルに追加しています。

### 読み取り専用モデル
`order_histories` と `order_history_entries` は読み取り専用モデル（Read Model）として設計されています。これらはCQRSパターンに基づき、クエリパフォーマンスを最適化するために使用されます。

---

## 変更履歴

| 日付 | バージョン | 変更内容 | 変更者 |
|------|-----------|---------|--------|
| 2025-01-XX | 1.0 | 初版作成 | - |

