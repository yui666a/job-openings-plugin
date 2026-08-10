# Job Opening（求人簡易投稿プラグイン）

WordPress サイト上で、求人情報を企業単位で登録・掲載するためのプラグインです。

WordPress の管理画面（wp-admin）を知らない一般ユーザーでも求人を投稿できるように、**フロント側の固定ページに配置したフォーム**から求人・企業情報を登録できる点が特徴です。企業情報を一度登録しておけば、以後の求人作成ではその企業を選ぶだけで住所や就業時間などが自動入力されます。

- Plugin Name: Job Opening
- Version: 0.1
- Author: yui666a（[STYLE ARTS](http://style-arts.jp/)）
- 動作要件: WordPress 5.9 以上（`JOB_OPENING__MINIMUM_WP_VERSION`）

---

## リポジトリ構成

| パス | 内容 |
| --- | --- |
| `job_opening_plugin/` | **プラグイン本体。** WordPress にインストールするのはこのディレクトリ |
| `mock/` | 実装前に作成した静的 HTML モック（`index.html` から辿れる） |
| `index.html` | モックへのリンク集 |

WordPress に入れるのは `job_opening_plugin/` だけです。`mock/` はデザイン検討用の資料であり、動作には不要です。

---

## インストール

### 1. プラグインを配置する

`job_opening_plugin/` を、WordPress の `wp-content/plugins/` 配下にコピーします。

```
wp-content/plugins/job_opening_plugin/
├── job_opening_plugin.php   ← プラグインのエントリポイント
├── routing.php
├── controller/
├── model/
├── view/
├── css/ js/ img/
└── util/
```

ZIP でアップロードする場合は、`job_opening_plugin` ディレクトリごと ZIP に固めて「プラグイン > 新規追加 > プラグインのアップロード」から導入します。

### 2. プラグインを有効化する

管理画面の「プラグイン」一覧から **Job Opening** を有効化します。有効化時（`register_activation_hook`）に、次の初期化処理が自動で走ります。

1. **データベーステーブルの作成**
   - `{prefix}sac_job_opening_companies` — 企業情報
   - `{prefix}sac_job_opening_companies_meta` — 企業情報のメタ情報
2. **画像アップロード先ディレクトリの作成**
   - `wp-content/uploads/sac_jo/company_images/`（企業ロゴの保存先）
3. **固定ページの自動生成**（後述のショートコードを埋め込んだ状態で公開されます）
4. **ページスラッグを保持するオプションの登録**（`sac_job_openings_list` など）

> **注意：無効化するとデータが消えます**
> `register_deactivation_hook` で `sac_job_opening_companies` と `sac_job_opening_companies_meta` の 2 テーブルを **DROP** します。登録済みの企業情報は失われるため、無効化の前にはバックアップを取ってください。
> （求人情報はカスタム投稿タイプ `job_openings` として `wp_posts` に保存されるため、こちらは削除されません。）

---

## 自動生成される固定ページ

有効化時に、以下の 6 ページが「公開」状態で作成されます。

| ページタイトル | スラッグ | 埋め込まれるショートコード | 役割 |
| --- | --- | --- | --- |
| 求人管理画面一覧 | `entry page` | `[entry_page]` | 各機能への入口（マイページ） |
| 企業情報を作成 | `add_company` | `[company_add]` | 企業情報の新規登録フォーム |
| 作成した企業一覧 | `company_list` | `[company_list]` | 自分が登録した企業の一覧・編集・削除 |
| 求人情報を作成 | `add_job_opening` | `[job_openings_add]` | 求人の新規登録フォーム |
| 作成した求人一覧 | `job_opening_list` | `[job_openings_list]` | 自分が作成した求人の一覧・編集・複製・公開/下書き切替 |
| 求人一覧 | `job_openings_table` | `[user_job_openings]` | **サイト訪問者向け**の公開求人一覧 |

ショートコードは固定ページに限らず、任意の投稿・ページに貼り付けて使えます。テーマの都合で自動生成ページを使わない場合は、これらのショートコードを自前のページに記述してください。

> **スラッグの整合性について**
> 入口ページ（`[entry_page]`）内のリンクは `/add_company` `/company_list` `/add_job_opening` `/job_opening_list` を直接指しています。自動生成された固定ページのスラッグを変更すると、この入口ページからの導線が切れます。スラッグを変更する場合は `view/entryPage.php` のリンク先も合わせて修正してください。
> なお `[user_job_openings]` のページだけはスラッグが `job_openings_table` で、入口ページからはリンクされていません（訪問者向けページのため）。

---

## 使い方

### 権限について

求人・企業の登録画面は、**ログインしていて次のいずれかの権限を持つユーザー**のみ閲覧できます。

`administrator` / `editor` / `author` / `contributor`

未ログイン、または権限がない場合は「このページは閲覧できません．ログインしてください」というメッセージとログイン画面へのボタンが表示されます。

編集・削除は所有者チェックが入り、**自分が作成した求人・企業のみ**操作できます。

### 手順 1. 企業情報を登録する

「企業情報を作成」ページ（`[company_add]`）から登録します。登録項目は次のとおりです。

- 企業名（必須）／業種／企業 URL
- 企業ロゴ（画像アップロード。`uploads/sac_jo/company_images/` に保存）
- 企業概要／PR ポイント
- 郵便番号／住所／住所 2（郵便番号から住所を自動入力）
- 就業時間／福利厚生／休日

求人は企業に紐づくため、**先に企業を 1 件以上登録しておく必要があります。**

### 手順 2. 求人情報を登録する

「求人情報を作成」ページ（`[job_openings_add]`）から登録します。

- **募集企業** — 手順 1 で登録した企業から選択。選ぶと住所・就業時間などがフォームに自動入力されます（`js/companyAutoInput.js`）
- **求人タイプ** — 新卒 / 中途 / どちらでも
- 求人タイトル／求人管理 ID／部署・役職名
- **職種** — 営業、事務・管理、ITエンジニアなど 14 分類から選択（`util/dictionaries.php`）
- 仕事内容／募集要件／労働条件（リッチテキストエディタ TinyMCE を使用）
- 勤務地（郵便番号・住所）／**リモートワーク** 可 / 不可 / 未選択
- 応募先 URL またはメールアドレス
- **掲載期間** — 次の 2 方式から選択
  - `period`: 投稿日から起算した日数を指定
  - それ以外: 掲載開始日と終了日を直接指定

「投稿する」で公開（`publish`）、「下書き保存」で下書き（`draft`）として保存されます。

保存された求人はカスタム投稿タイプ `job_openings` として登録され、各項目は `_title` `_work_detail` `_expired_date` などのカスタムフィールドにも保存されます。

### 手順 3. 掲載を管理する

「作成した求人一覧」ページ（`[job_openings_list]`）では、URL パラメータによって以下の操作ができます。

| 操作 | URL 例 |
| --- | --- |
| 編集 | `?action=edit&post={投稿ID}` |
| 複製して新規作成 | `?action=copy&post={投稿ID}` |
| 下書きに戻す | `?action=draft&post={投稿ID}` |
| 公開する | `?action=publish&post={投稿ID}` |

「作成した企業一覧」ページ（`[company_list]`）では、編集（`?action=edit&id={企業ID}`）と削除（`?action=remove&id={企業ID}`）ができます。

### 訪問者向けの求人一覧

`[user_job_openings]` を貼ったページには、**公開済みかつ掲載期限内**の求人だけが新着順で表示されます。掲載終了日（`_expired_date`）を過ぎた求人は自動的に一覧から外れます（投稿自体が削除・非公開になるわけではありません）。

個別の求人ページは、専用テンプレート `view/template/single-job_openings.php` で表示されます。

---

## 管理画面からの操作

フロントの固定ページとは別に、wp-admin の左メニューにも「**求人簡易投稿**」が追加されます（`manage_options` 権限、通常は管理者のみ）。

- 求人一覧
- 企業一覧
- 求人 新規作成
- 企業 新規作成
- 設定（**未実装**）

---

## 登録されるカスタム投稿タイプ・タクソノミー

| 種別 | 名前 | 表示名 |
| --- | --- | --- |
| カスタム投稿タイプ | `job_openings` | 求人情報（URL: `/job_openings/`、アーカイブ有効） |
| タクソノミー（階層あり） | `job_openings-category` | カテゴリー |
| タクソノミー（階層なし） | `job_openings-tag` | タグ |

---

## 依存している外部リソース

以下は CDN から読み込まれるため、**インターネットに接続できる環境が必要**です。

- jQuery 3.5.1（`code.jquery.com`）— WordPress 同梱の jQuery は `wp_deregister_script` で解除して差し替えています
- select2 4.1.0-beta.1（`cdn.jsdelivr.net`）— セレクトボックスの UI
- YubinBango（`yubinbango.github.io`）— 郵便番号からの住所自動入力

TinyMCE はプラグイン内に同梱しています（`js/tinymce/`）。

また、入口ページ（`[entry_page]`）のアイコン画像は `https://nagaoka-worker.jp/` 上の画像を直接参照しています。他サイトで利用する場合は、同梱の `img/icon-*.png` を使うよう `view/entryPage.php` を修正してください。

---

## ディレクトリ構成（プラグイン本体）

```
job_opening_plugin/
├── job_opening_plugin.php  プラグイン定義、定数、CSS/JS 読み込み、有効化/無効化処理、
│                           ショートコード登録、カスタム投稿タイプ・タクソノミー登録
├── routing.php             各ファイルの読み込みと wp-admin メニューの登録
├── model/
│   └── createDB.php        企業テーブル・企業メタテーブルの作成（dbDelta）
├── controller/
│   ├── create_card.php     求人の新規登録処理（POST 受け取り → wp_insert_post）
│   ├── create_company.php  企業の新規登録処理（POST 受け取り → $wpdb->insert）
│   ├── editJob.php         求人の編集処理
│   ├── editCompany.php     企業の編集処理
│   ├── job_opening.php     公開済み求人の取得
│   └── company.php         企業の取得・削除
├── view/
│   ├── view.php            ショートコードの実体。権限判定と画面の振り分け
│   ├── entryPage.php       入口ページ（マイページ）
│   ├── jobTable.php        求人一覧
│   ├── companyTable.php    企業一覧
│   └── template/           各画面の HTML テンプレート
├── util/
│   └── dictionaries.php    職種コード ⇔ 日本語名の対応表
├── css/  js/  img/
└── readme.md               開発メモ
```

## データの保存先

| データ | 保存先 |
| --- | --- |
| 企業情報 | `{prefix}sac_job_opening_companies` テーブル |
| 企業メタ情報 | `{prefix}sac_job_opening_companies_meta` テーブル |
| 求人情報 | カスタム投稿タイプ `job_openings`（`wp_posts` / `wp_postmeta`） |
| 企業ロゴ画像 | `wp-content/uploads/sac_jo/company_images/` |
| ページスラッグ設定 | `wp_options`（`sac_job_openings_list` 等） |

---

## 開発時のメモ

- デバッグ表示のため `wp-config.php` の `WP_DEBUG` を `true` にして開発しています。公開時は `false` に戻してください。
- `console_log()` / `console_error()` ヘルパーが定義されており、PHP から `console.log` に値を出力できます。
- `mock/` 配下の SCSS（`mock/sass/`）をコンパイルしたものが `job_opening_plugin/css/` に配置されています。

## 未実装・既知の制約

- 管理画面の「設定」ページは未実装です（`routing.php` の `settings` に TODO）。
- 二重投稿を防ぐワンタイムチケットは生成・保存まで実装されていますが、検証部分がコメントアウトされており機能していません（`create_card.php` / `create_company.php`）。
- プラグイン無効化時に企業テーブルが削除されます。アンインストールではなく無効化の時点で消える点に注意してください。
