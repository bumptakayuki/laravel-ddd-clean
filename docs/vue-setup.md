# Vue.js 注文管理画面 セットアップガイド

## 概要

このドキュメントでは、注文関連のVue.js画面のセットアップ方法を説明します。

## 必要なパッケージのインストール

以下のコマンドで必要なパッケージをインストールしてください：

```bash
npm install
```

インストールされるパッケージ：
- `vue`: Vue.js 3.x
- `@vitejs/plugin-vue`: Vite用のVue.jsプラグイン
- `axios`: HTTPクライアント（既にインストール済み）

## ファイル構成

```
resources/
├── js/
│   ├── api/
│   │   └── orderApi.js          # APIクライアント
│   ├── components/
│   │   ├── OrderApp.vue          # メインアプリケーション
│   │   ├── OrderList.vue         # 注文一覧画面
│   │   ├── OrderCreate.vue       # 注文作成画面
│   │   └── OrderDetail.vue       # 注文詳細画面（決済・受注・購入確定）
│   ├── app.js                    # エントリーポイント
│   └── bootstrap.js              # 初期設定
└── views/
    └── orders.blade.php          # 注文管理画面のBladeテンプレート
```

## 開発サーバーの起動

開発モードで起動する場合：

```bash
npm run dev
```

本番用にビルドする場合：

```bash
npm run build
```

## アクセス方法

ブラウザで以下のURLにアクセスしてください：

```
http://localhost/orders
```

## 機能説明

### 1. 注文一覧画面（OrderList.vue）

- 会員IDを指定して注文一覧を取得
- 注文の状態（未決済、決済済み、受注済み、購入確定）を表示
- 注文をクリックすると詳細画面に遷移

### 2. 注文作成画面（OrderCreate.vue）

- 会員ID、店舗IDを入力
- 複数の注文明細を追加可能
- 各明細に構成ID、単価、数量を設定
- 注文作成後、自動的に詳細画面に遷移

### 3. 注文詳細画面（OrderDetail.vue）

- 注文の基本情報と明細を表示
- 状態に応じて以下の操作が可能：
  - **未決済**: 決済を実行（決済手段、取引IDを入力）
  - **決済済み**: 注文を受注
  - **受注済み**: 購入を確定
  - **購入確定**: 操作不可（完了メッセージ表示）

## APIエンドポイント

以下のAPIエンドポイントが使用されます：

- `GET /api/orders?member_id={memberId}` - 注文一覧取得
- `POST /api/orders` - 注文作成
- `POST /api/orders/{orderId}/payment` - 決済実行
- `POST /api/orders/{orderId}/acceptance` - 受注実行
- `POST /api/orders/{orderId}/purchase` - 購入確定

## 注意事項

1. **会員ID**: 現在はハードコードされています（`member-001`）。実際の実装では認証システムから取得してください。

2. **CSRFトークン**: BladeテンプレートにCSRFトークンのメタタグが含まれている必要があります。`orders.blade.php`に既に含まれています。

3. **エラーハンドリング**: APIエラーは各コンポーネントで適切に処理され、ユーザーに表示されます。

4. **状態管理**: 現在は各コンポーネントで状態を管理しています。より複雑なアプリケーションの場合は、VuexやPiniaなどの状態管理ライブラリの導入を検討してください。

## カスタマイズ

### 会員IDの動的取得

`OrderList.vue`、`OrderCreate.vue`、`OrderDetail.vue`の`memberId`を実際の認証システムから取得するように変更してください。

### ルーティング

現在は親コンポーネント（`OrderApp.vue`）で画面遷移を管理しています。より複雑なルーティングが必要な場合は、Vue Routerの導入を検討してください。

### スタイリング

Tailwind CSSを使用しています。必要に応じてカスタマイズしてください。

