# Laravel 11 サンプル

# 概要

このサンプルは、[Laravel 11 の開発環境をdockerで実現する方法](https://qiita.com/hitotch/items/2e816bc1423d00562dc2)の記事をほぼそのまま実体化したものです。詳細は記事を読んでください。

# 開発環境構築

## Docker用の初期設定

まずは以下手順で必要なファイルやディレクトリを生成する。（このディレクトリ、ファイルは環境に依存するため、Git の管理外にしているため）

```bash
# ログファイルを格納するディレクトリを作る
$ mkdir ./docker/nginx/logs

# MySQLで使用するディレクトリを作る、このディレクトリはignoreしないとgit add できなくなる
$ mkdir ./docker/mysql

# githubで管理した時にignoreされたファイルをなかったら作る
$ echo '' >> ./storage/logs/laravel.log
```

## Dockerの起動

```bash
# Dockerコンテナを起動
docker compose up -d
```

# 設置後の初期設定

Dockerで起動した場合は以下でDockerコンテナ「l11sample-app」にターミナル接続する。実際のサーバーの場合はSSH接続する。

```bash
docker compose exec l11sample-app bash
```

## Laravel用の初期設定

```bash
# .envファイルをサンプルから作る
cp .env.example .env

# .envファイルを編集モードで開く
vi .env

# データベースの部分のみ下記に変更して、.envを保存。以下の値はDockerを使う場合なので、実際のサーバーに設置する場合はサーバーに合わせる。
DB_CONNECTION=mysql
DB_HOST=l11sample-mysql
DB_PORT=3306
DB_DATABASE=l11sample
DB_USERNAME=root
DB_PASSWORD=root

# Cookieのセキュリティ設定。本番環境ではSSL通信前提でtrueに、開発環境でSSL通信しない場合はfalseにすること。
SESSION_SECURE_COOKIE=true
```

## Laravelが使うファイルやDBの初期設定

```bash
# Composerでライブラリをインストール
composer install

# keyを生成
php artisan key:generate

# ストレージ用のシンボリックリンクを追加
php artisan storage:link

# マイグレーションを実行
php artisan migrate

# マスターテーブルのシーディング
php artisan db:seed
```

## アセット(sass や js)のコンパイル

利用には、node モジュールが必要。

```bash
npm install
```

コンパイル

```bash
npm run build
```

## ドキュメントルートについて

ドキュメントルートは、プロジェクト内のpublicフォルダとすること。
Docker環境ではすでに設定済み。

# 動作確認

Docker環境なら、ブラウザで`http://localhost`にアクセスすれば確認ができる。本番なら本番サイトURLへ。