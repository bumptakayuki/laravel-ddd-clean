# ユビキタス言語（Ubiquitous Language）

## Box Lunch Context（Core Domain）

### 中心概念（名詞）

* **Box Lunch**：販売単位となる弁当商品
* **Box Lunch Detail**：商品詳細（説明、価格、画像、提供条件など）
* **Option**：Box Lunch に付随する選択肢（例：ご飯大盛り、トッピング）
* **Option Selection**：ユーザーが選んだオプションの集合
* **Box Lunch Configuration**：Box Lunch + Option Selection で確定した構成
* **Availability**：提供可能状態（在庫、提供時間、エリア対応などの結果）
* **Price Rule**：価格計算ルール（オプション加算、割引等が将来入る想定）

### 動詞（行為）

* **Browse Box Lunches**：弁当一覧を閲覧する
* **Select Box Lunch**：弁当を選択する
* **Select Options**：オプションを選択する
* **Confirm Configuration**：構成を確定する
* **Check Availability**：提供可否を判定する

### ドメインイベント（用語として統一）

* **BoxLunchSelected**
* **OptionsSelected**
* **BoxLunchConfigured**

---

## Store Context（Supporting）

### 名詞

* **Store**：店舗
* **Store List**：店舗一覧
* **Store Detail**：店舗詳細
* **Store Search Criteria**：店舗検索条件（主にエリア条件）

### 動詞

* **Search Stores**：店舗を検索する
* **View Store Detail**：店舗詳細を表示する

### イベント

* **StoreSearched**
* **StoreSelected**

---

## Area Context（Generic）

### 名詞

* **Area**：エリア（配達・検索の単位）
* **Current Area**：現在選択中のエリア
* **Area Selection**：エリア選択結果

### 動詞

* **Select Area**：エリアを選択する

### イベント

* **AreaSelected**

---

## Member Context（Generic）

### 名詞

* **Member**：会員
* **Credential**：認証情報
* **Profile**：会員情報（住所・電話等がここに寄りやすい）
* **Session**：ログイン状態

### 動詞

* **Sign Up**：会員登録する
* **Log In**：ログインする
* **Update Profile**：会員情報を更新する

### イベント

* **MemberRegistered**
* **MemberLoggedIn**
* **MemberProfileUpdated**

---

## Favorite Context（Generic）

### 名詞

* **Favorite**：お気に入り
* **Favorite Store**：お気に入り店舗
* **Favorite Box Lunch**：お気に入り弁当
* **Favorite Entry**：お気に入り1件（対象種別＋対象ID）

### 動詞

* **Add to Favorites**：お気に入りに追加する
* **Remove from Favorites**：お気に入りから削除する

### イベント

* **FavoriteAdded**
* **FavoriteRemoved**

---

## Order Context（Supporting）

### 名詞

* **Order**：注文（ライフサイクルを持つ中心）
* **Order Item**：注文内訳（Box Lunch Configuration を参照してもよい）
* **Order Status**：注文状態
    * **Pending Payment**（未決済）
    * **Paid**（決済済み）
    * **Accepted**（受注済み）
    * （将来：Cancelled / Failed など）
* **Order Confirmation**：注文確定（ユーザー操作の意味）
* **Notification**：通知（メール等）

### 動詞

* **Place Order**：注文を作成する（＝注文する）
* **Cancel Order**：注文をキャンセルする
* **Send Order Completion Email**：注文完了メールを送る
* **Send Order Failure Email**：注文失敗メールを送る

### イベント

* **OrderPlaced**
* **OrderCancelled**
* **OrderCompletedEmailSent**
* **OrderFailedEmailSent**

---

## Payment Context（Supporting）

### 名詞

* **Payment**：決済
* **Payment Method**：決済手段
* **Payment Transaction**：決済取引（外部決済のトランザクション）
* **Payment Status**
    * **Succeeded**
    * **Failed**

### 動詞

* **Authorize Payment / Capture Payment**（外部決済が分かれる場合に備えた語彙）
* **Execute Payment**：決済を実行する

### イベント

* **PaymentSucceeded**
* **PaymentFailed**

---

## Acceptance Context（Supporting）

### 名詞

* **Acceptance**：受注（店舗側が注文を受け付けること）
* **Acceptance Notification**：受注通知

### 動詞

* **Accept Order**：注文を受注する
* **Notify Store**：店舗へ通知する

### イベント

* **OrderAccepted**
* **AcceptanceNotified**

---

## Purchase Context（Supporting）

### 名詞

* **Purchase**：購入確定（注文と別で「確定」を扱う）
* **Purchase Record**：購入記録
* **Purchase Confirmation**：購入確定通知

### 動詞

* **Confirm Purchase**：購入を確定する
* **Send Purchase Confirmation Email**：購入確定メールを送信する

### イベント

* **PurchaseConfirmed**
* **PurchaseConfirmationEmailSent**

---

## Order History Context（Supporting / Read Model寄り）

### 名詞

* **Order History**：注文履歴
* **Order History Entry**：履歴1件
* **History View**：履歴表示用のビュー（読み取りモデル）

### 動詞

* **Generate Order History**：注文履歴を作成する（＝投影する）
* **View Order History**：注文履歴を参照する

### イベント

* **OrderHistoryCreated**
* **OrderHistoryViewed**

