# コーディング規約

## 目次

1. [プロジェクト概要](#プロジェクト概要)
2. [設計思想](#設計思想)
3. [ディレクトリ構成](#ディレクトリ構成)
4. [レイヤー別コーディング規約](#レイヤー別コーディング規約)
5. [命名規則](#命名規則)
6. [依存関係のルール](#依存関係のルール)
7. [ファイル構成規約](#ファイル構成規約)
8. [コーディングスタイル](#コーディングスタイル)

---

## プロジェクト概要

このプロジェクトは、**ドメイン駆動設計（DDD）**と**クリーンアーキテクチャ**の設計思想に基づいて、コンテキスト単位で開発を行います。

### コンテキスト単位の開発

- 各コンテキストは独立したパッケージとして `packages/{ContextName}/` 配下に配置
- コンテキスト内で完結するビジネスロジックを実装
- コンテキスト間の依存関係は最小限に保つ

---

## 設計思想

### クリーンアーキテクチャの原則

1. **依存性逆転の原則（DIP）**
   - 内側のレイヤー（Domain）は外側のレイヤー（Infrastructure）に依存しない
   - 外側のレイヤーが内側のレイヤーのインターフェースに依存する

2. **単一責任の原則（SRP）**
   - 各クラスは1つの責任のみを持つ
   - UseCaseは1つのビジネスユースケースのみを実装

3. **依存関係の方向**
   ```
   Controller → UseCase → Domain ← Infrastructure
   ```

### DDDの原則

1. **エンティティ（Entity）**
   - 一意の識別子を持つ
   - ビジネスルールを含む

2. **値オブジェクト（Value Object）**
   - 不変（immutable）
   - 値による等価性判定

3. **リポジトリ（Repository）**
   - ドメインオブジェクトの永続化を抽象化
   - インターフェースはDomain層、実装はInfrastructure層

4. **ユースケース（UseCase）**
   - アプリケーションのビジネスロジックを実装
   - ドメインオブジェクトを操作する

---

## ディレクトリ構成

### プロジェクト全体の構成

```
laravel-ddd-clean/
├── app/                    # Laravel標準のアプリケーションコード
├── packages/               # コンテキスト単位のパッケージ
│   └── {ContextName}/     # コンテキスト名（例: SampleUserContext）
│       └── {Aggregate}/   # 集約ルート名（例: User）
│           ├── Adapter/   # アダプタ層
│           ├── Domain/    # ドメイン層
│           ├── Infrastructure/  # インフラストラクチャ層
│           └── UseCase/   # ユースケース層
├── docs/                  # ドキュメント
└── ...
```

### コンテキスト内のディレクトリ構成

```
packages/{ContextName}/{Aggregate}/
├── Adapter/
│   └── Controller/
│       └── {Aggregate}Controller.php
│
├── Domain/
│   ├── {Aggregate}.php                    # エンティティ
│   ├── {Aggregate}Item.php                # エンティティ（関連エンティティ）
│   ├── Repository/
│   │   └── {Aggregate}RepositoryInterface.php
│   └── ValueObject/
│       ├── {Aggregate}Id.php
│       ├── {Aggregate}Name.php
│       ├── {Aggregate}Email.php
│       └── ...
│
├── Infrastructure/
│   └── Eloquent/
│       ├── Model/
│       │   ├── Eloquent{Aggregate}.php       # Eloquentモデル
│       │   └── Eloquent{Aggregate}Item.php  # Eloquentモデル（関連モデル）
│       └── Repository/
│           └── {Aggregate}Repository.php     # リポジトリ実装
│
└── UseCase/
    ├── Create{Aggregate}/
    │   ├── ICreate{Aggregate}UseCase.php
    │   ├── Create{Aggregate}Interactor.php
    │   ├── Create{Aggregate}InputData.php
    │   └── Create{Aggregate}OutputData.php
    ├── Update{Aggregate}/
    │   ├── IUpdate{Aggregate}UseCase.php
    │   ├── Update{Aggregate}Interactor.php
    │   └── Update{Aggregate}InputData.php
    ├── List{Aggregate}s/
    │   ├── IList{Aggregate}sUseCase.php
    │   ├── List{Aggregate}sInteractor.php
    │   ├── List{Aggregate}sInputData.php
    │   └── List{Aggregate}sOutputData.php
    └── Delete{Aggregate}/
        ├── IDelete{Aggregate}UseCase.php
        ├── Delete{Aggregate}Interactor.php
        └── Delete{Aggregate}InputData.php
```

### ディレクトリ命名規則

- **コンテキスト名**: PascalCase（例: `SampleUserContext`）
- **集約ルート名**: PascalCase（例: `User`, `Order`）
- **レイヤー名**: PascalCase（例: `Adapter`, `Domain`, `Infrastructure`, `UseCase`）
- **ディレクトリ名**: PascalCase（例: `Controller`, `ValueObject`, `Repository`）

---

## レイヤー別コーディング規約

### Adapter Layer（アダプタ層）

#### 役割
- 外部からの入力をアプリケーションに適した形式に変換
- アプリケーションの出力を外部に適した形式に変換
- HTTPリクエスト/レスポンスの処理

#### コーディング規約

**Controller**

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\Adapter\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\{ContextName}\{Aggregate}\UseCase\{Action}{Aggregate}\I{Action}{Aggregate}UseCase;
use Packages\{ContextName}\{Aggregate}\UseCase\{Action}{Aggregate}\{Action}{Aggregate}InputData;

class {Aggregate}Controller extends Controller
{
    public function __construct(
        private readonly I{UseCaseName}UseCase $useCase
    ) {}

    public function index()
    {
        $output = $this->useCase->handle();
        return response()->json($output->data);
    }
}
```

**規約**
- `App\Http\Controllers\Controller` を継承
- UseCaseのインターフェースをコンストラクタで注入（依存性注入）
- リクエストのバリデーションはControllerで行う（またはFormRequestを使用）
- レスポンスはJSON形式で返す

---

### UseCase Layer（ユースケース層）

#### 役割
- アプリケーション固有のビジネスロジックを実装
- ドメインオブジェクトを操作してユースケースを実行

#### ディレクトリ構成

各ユースケースは独立したディレクトリに配置。**ディレクトリ名は名前空間と一致させる必要がある**（PSR-4準拠）：

```
UseCase/
└── {Action}{Aggregate}/                    # CreateOrder, UpdateUser, ListOrders など
    ├── I{Action}{Aggregate}UseCase.php      # インターフェース
    ├── {Action}{Aggregate}Interactor.php    # 実装
    ├── {Action}{Aggregate}InputData.php     # 入力データ
    └── {Action}{Aggregate}OutputData.php    # 出力データ（必要な場合）
```

**重要**: ディレクトリ名は `{Action}{Aggregate}` の形式にする（例: `CreateOrder`, `ListOrders`）。単に `Create` や `List` ではなく、集約名を含めることで名前空間と一致させる。

#### コーディング規約

**UseCaseインターフェース**

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\UseCase\{Action}{Aggregate};

interface I{Action}{Aggregate}UseCase
{
    public function handle({Action}{Aggregate}InputData $input): {Action}{Aggregate}OutputData;
}
```

**規約**
- インターフェース名は `I` で始める
- `handle` メソッドを定義
- 入力は `InputData` オブジェクト、出力は `OutputData` オブジェクト

**UseCase実装（Interactor）**

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\UseCase\{Action}{Aggregate};

use Packages\{ContextName}\{Aggregate}\Domain\{Aggregate};
use Packages\{ContextName}\{Aggregate}\Domain\Repository\{Aggregate}RepositoryInterface;

class {Action}{Aggregate}Interactor implements I{Action}{Aggregate}UseCase
{
    public function __construct(
        private readonly {Aggregate}RepositoryInterface $repository
    ) {}

    public function handle({Action}{Aggregate}InputData $input): {Action}{Aggregate}OutputData
    {
        // ビジネスロジックの実装
        $entity = new {Aggregate}(...);
        $this->repository->save($entity);
        
        return new {Action}{Aggregate}OutputData(...);
    }
}
```

**規約**
- インターフェースを実装
- リポジトリのインターフェースをコンストラクタで注入
- ドメインエンティティを操作
- 実装クラス名は `{Action}{Aggregate}Interactor`

**InputData / OutputData**

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\UseCase\{Action}{Aggregate};

class {Action}{Aggregate}InputData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        // ...
    ) {}
}
```

**規約**
- プロパティは `public readonly` で定義
- コンストラクタで初期化
- バリデーションロジックは含めない（ControllerまたはFormRequestで実施）

---

### Domain Layer（ドメイン層）

#### 役割
- ビジネスルールとドメインロジックを表現
- 他のレイヤーに依存しない純粋なドメインロジック

#### コーディング規約

**エンティティ（Entity）**

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\Domain;

class {Aggregate}
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        // ...
    ) {}
}
```

**規約**
- プロパティは `public readonly` で定義
- 不変（immutable）を原則とする
- ビジネスルールを含むメソッドを定義可能
- 名前空間は `Domain`（エンティティは`Domain`直下に配置）

**値オブジェクト（Value Object）**

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\Domain\ValueObject;

use InvalidArgumentException;

class {Aggregate}Name
{
    public function __construct(
        private readonly string $value
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException('名前は必須です。');
        }

        if (mb_strlen($this->value) > 50) {
            throw new InvalidArgumentException('名前は50文字以内で入力してください。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
```

**規約**
- プロパティは `private readonly` で定義
- コンストラクタでバリデーションを実施
- `getValue()` メソッドで値を取得
- 不変（immutable）であることを保証
- 名前空間は `Domain\ValueObject`

**リポジトリインターフェース**

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\Domain\Repository;

use Packages\{ContextName}\{Aggregate}\Domain\{Aggregate};

interface {Aggregate}RepositoryInterface
{
    public function save({Aggregate} $entity): void;
    public function findById(int $id): ?{Aggregate};
    public function findAll(): array;
    public function delete({Aggregate} $entity): void;
}
```

**規約**
- インターフェース名は `{Aggregate}RepositoryInterface`
- ドメインエンティティを引数・戻り値に使用
- 名前空間は `Domain\Repository`
- 実装の詳細（Eloquent等）は含めない

---

### Infrastructure Layer（インフラストラクチャ層）

#### 役割
- 外部システムとの連携（データベース、外部API等）
- ドメイン層のインターフェースを実装

#### コーディング規約

**Eloquentモデル**

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class Eloquent{Aggregate} extends Model
{
    protected $table = '{aggregate}s';
    
    protected $fillable = [
        'name',
        'email',
        // ...
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
```

**規約**
- クラス名は `Eloquent{Aggregate}`
- LaravelのEloquentモデルを継承
- 名前空間は `Infrastructure\Eloquent\Model`
- テーブル名はスネークケースの複数形

**リポジトリ実装**

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\Infrastructure\Eloquent\Repository;

use Packages\{ContextName}\{Aggregate}\Domain\{Aggregate};
use Packages\{ContextName}\{Aggregate}\Domain\Repository\{Aggregate}RepositoryInterface;
use Packages\{ContextName}\{Aggregate}\Infrastructure\Eloquent\Model\Eloquent{Aggregate};

class {Aggregate}Repository implements {Aggregate}RepositoryInterface
{
    public function save({Aggregate} $entity): void
    {
        Eloquent{Aggregate}::create([
            'name' => $entity->name,
            // ...
        ]);
    }

    public function findById(int $id): ?{Aggregate}
    {
        $eloquent = Eloquent{Aggregate}::find($id);
        if (!$eloquent) {
            return null;
        }

        return $this->toEntity($eloquent);
    }

    private function toEntity(Eloquent{Aggregate} $eloquent): {Aggregate}
    {
        return new {Aggregate}(
            $eloquent->id,
            $eloquent->name,
            // ...
        );
    }
}
```

**規約**
- ドメインのリポジトリインターフェースを実装
- Eloquentモデルとドメインエンティティの変換を行う
- 名前空間は `Infrastructure\Eloquent\Repository`
- ドメインエンティティを返す際は `toEntity()` メソッドで変換

---

## 命名規則

### クラス名

| 種類 | 命名規則 | 例 |
|------|---------|-----|
| エンティティ | PascalCase | `User`, `Order` |
| 値オブジェクト | PascalCase | `UserName`, `UserEmail` |
| リポジトリインターフェース | `{Aggregate}RepositoryInterface` | `UserRepositoryInterface` |
| リポジトリ実装 | `{Aggregate}Repository` | `UserRepository` |
| UseCaseインターフェース | `I{Action}{Aggregate}UseCase` | `ICreateUserUseCase` |
| UseCase実装 | `{Action}{Aggregate}Interactor` | `CreateUserInteractor` |
| InputData | `{Action}{Aggregate}InputData` | `CreateUserInputData` |
| OutputData | `{Action}{Aggregate}OutputData` | `ListUsersOutputData` |
| Controller | `{Aggregate}Controller` | `UserController` |
| Eloquentモデル | `Eloquent{Aggregate}` | `EloquentUser` |

### メソッド名

| 種類 | 命名規則 | 例 |
|------|---------|-----|
| UseCase実行 | `handle` | `handle(InputData $input)` |
| リポジトリ保存 | `save` | `save(Entity $entity)` |
| リポジトリ取得 | `findById`, `findAll` | `findById(int $id)` |
| リポジトリ削除 | `delete` | `delete(Entity $entity)` |
| 値オブジェクト取得 | `getValue` | `getValue(): string` |

### 変数名

- **camelCase** を使用
- 意味のある名前を付ける
- 略語は避ける（例: `$usr` → `$user`）

### 定数名

- **UPPER_SNAKE_CASE** を使用
- クラス定数として定義

---

## 依存関係のルール

### 依存関係の方向

```
Adapter → UseCase → Domain ← Infrastructure
```

### 各レイヤーの依存関係

1. **Adapter Layer**
   - ✅ UseCase Layer に依存可能
   - ❌ Domain Layer に直接依存しない
   - ❌ Infrastructure Layer に依存しない

2. **UseCase Layer**
   - ✅ Domain Layer に依存可能
   - ❌ Infrastructure Layer に直接依存しない（インターフェース経由のみ）
   - ❌ Adapter Layer に依存しない

3. **Domain Layer**
   - ❌ 他のレイヤーに依存しない（最内層）
   - ✅ 自分自身のレイヤー内のクラスに依存可能

4. **Infrastructure Layer**
   - ✅ Domain Layer のインターフェースを実装
   - ✅ Eloquent等の外部ライブラリに依存可能
   - ❌ UseCase Layer に依存しない

### 依存性注入（DI）

- コンストラクタインジェクションを使用
- インターフェースに依存する（具象クラスに依存しない）
- Laravelのサービスコンテナを活用

**例: UseCaseの依存性注入**

```php
// UseCase実装
class CreateUserInteractor implements ICreateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $repository  // インターフェースに依存
    ) {}
}

// サービスプロバイダーでバインド
public function register(): void
{
    $this->app->bind(
        UserRepositoryInterface::class,
        UserRepository::class
    );
}
```

---

## ファイル構成規約

### ファイル名

- クラス名とファイル名は一致させる
- 1ファイル1クラス
- ファイル名は PascalCase

### 名前空間

名前空間はディレクトリ構造と一致させる（PSR-4準拠）：

```
packages/{ContextName}/{Aggregate}/Domain/Entity/User.php
→ namespace Packages\{ContextName}\{Aggregate}\Domain\Entity;

packages/{ContextName}/{Aggregate}/Domain/Repository/UserRepositoryInterface.php
→ namespace Packages\{ContextName}\{Aggregate}\Domain\Repository;

packages/{ContextName}/{Aggregate}/Infrastructure/Eloquent/Model/EloquentUser.php
→ namespace Packages\{ContextName}\{Aggregate}\Infrastructure\Eloquent\Model;

packages/{ContextName}/{Aggregate}/Infrastructure/Eloquent/Repository/UserRepository.php
→ namespace Packages\{ContextName}\{Aggregate}\Infrastructure\Eloquent\Repository;

packages/{ContextName}/{Aggregate}/UseCase/CreateUser/CreateUserInteractor.php
→ namespace Packages\{ContextName}\{Aggregate}\UseCase\CreateUser;
```

**重要**: ディレクトリ名と名前空間は完全に一致させる必要がある。不一致があると、PSR-4のオートローダーがクラスを見つけられない。

### ファイル構造

```php
<?php
namespace Packages\{ContextName}\{Aggregate}\{Layer}\{SubDirectory};

// use文（アルファベット順）
use Package1\Class1;
use Package2\Class2;

// クラス定義
class ClassName
{
    // 定数
    // プロパティ
    // コンストラクタ
    // メソッド
}
```

---

## コーディングスタイル

### PHPコーディング規約

- **PSR-12** に準拠
- インデント: 4スペース
- 行の最大長: 120文字
- 末尾の空白を削除

### 型宣言

- 可能な限り型宣言を追加
- 戻り値の型を明示
- `readonly` プロパティを積極的に使用（PHP 8.1+）

### コメント

- PHPDocコメントを記述
- 複雑なロジックには説明コメントを追加
- 日本語コメントも可

**例:**

```php
/**
 * ユーザーを作成する
 * 
 * @param CreateUserInputData $input ユーザー作成の入力データ
 * @return void
 * @throws InvalidArgumentException バリデーションエラー時
 */
public function handle(CreateUserInputData $input): void
{
    // ビジネスロジックの実装
}
```

### エラーハンドリング

- ドメイン例外を定義して使用
- 値オブジェクトのバリデーションエラーは `InvalidArgumentException` をスロー
- リポジトリのエラーは適切な例外をスロー

### テスト

- 各レイヤーに対してユニットテストを記述
- ドメインロジックのテストを優先
- モックを使用して依存関係を分離

---

## まとめ

このコーディング規約に従うことで、以下のメリットが得られます：

1. **保守性の向上**: 一貫した構造により、コードの理解が容易
2. **テスタビリティ**: 依存関係が明確で、テストが容易
3. **拡張性**: 新しい機能の追加が容易
4. **独立性**: コンテキスト単位で独立した開発が可能

開発時は、この規約を参照しながら実装を進めてください。

