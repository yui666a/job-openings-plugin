# CLAUDE.md

このリポジトリで作業する際のガイド。**運用ルール（ブランチ・コミット・PR）を最優先で守ること。**

プラグインの機能・画面・インストール手順は [README.md](README.md) に記載されている。ここでは README と重複しない「どう作業するか」を定義する。

## プロジェクト概要

WordPress プラグイン「Job Opening（求人簡易投稿プラグイン）」。管理画面を使わず、固定ページのショートコードから求人・企業情報を投稿できる。素の PHP + jQuery で構成され、ビルドツール・パッケージマネージャ・テストフレームワークは導入していない。

- 本体: `job_opening_plugin/`（MVC 風に `model/` `view/` `controller/`）
- デモサイト生成: `tools/demo/`（`generate.php` + `screenshot.mjs` → `docs/`）
- モック HTML と SCSS: `mock/`

## 作業の前提

### ベースブランチは `dev`

`master` は残っているが更新されていない。**PR のベースは常に `dev`** とする。

### Issue 駆動で進める

コードレビューで検出した欠陥は Issue #39〜#56 に登録済みで、対応順は **#56** にまとまっている。作業を始める前に対象 Issue を `gh issue view <番号>` で確認し、Issue がない変更を始めない。Issue のない作業を依頼された場合は、先に Issue を立てるか、ユーザーに確認する。

```bash
gh issue list --state open
gh issue view 56
```

GitHub の URL を渡された場合は、ブラウザで開かず `gh` コマンドで取得する。

## 運用ルール

### 1. worktree で作業する

**`dev` を直接編集しない。** 作業開始時は必ず worktree を切り、そこで実装する。メインの作業ツリーは常に `dev` の最新状態を保ち、複数の Issue を並行して進められるようにする。

```bash
# worktree を作成して移動する
git worktree add ../job-openings-plugin-worktrees/<ブランチ名> -b <ブランチ名> origin/dev

# 作業完了・PR マージ後に削除する
git worktree remove ../job-openings-plugin-worktrees/<ブランチ名>
git branch -d <ブランチ名>
```

worktree の置き場所は `../job-openings-plugin-worktrees/` 配下に統一する（リポジトリ内に作るとプラグイン本体のスキャン対象に混ざるため）。

### 2. ブランチ名

`<種別>/<Issue番号>-<英小文字ケバブの要約>` とする。Issue 番号を含めることで、ブランチ・PR・Issue が後から追跡できる。

| 種別 | 用途 |
| --- | --- |
| `fix/` | バグ修正・セキュリティ修正 |
| `feature/` | 機能追加 |
| `refactor/` | 挙動を変えない整理 |
| `docs/` | ドキュメントのみ |
| `chore/` | 雑務・設定 |

例: `fix/42-prepare-company-query` / `refactor/53-unify-job-persistence`

### 3. コミット粒度とメッセージ

**粒度**: 1 コミット = 1 つの論理的変更。「レビュー時にこのコミットだけを見て意味が通るか」で判断する。

- 関係のない変更を同じコミットに混ぜない
- 迷ったら小さく分ける
- ステージングは `git add <ファイル名>` で明示する。`git add -A` / `git add .` は使わない
- フォーマット変更と挙動変更は別コミットにする（差分がノイズで埋まるため）

**メッセージ**: 日本語の Conventional Commits。件名は「何をしたか」ではなく **なぜそうしたか（Why）** が読み取れるように書く。

```
fix: 企業情報のクエリを prepare 経由にして SQL インジェクションを塞ぐ

$_GET の値を直接連結していたため、任意のクエリを実行できる状態だった。
$wpdb->prepare() でプレースホルダを通すよう変更する。

Refs #42
```

- プレフィックス: `feat:` / `fix:` / `refactor:` / `docs:` / `test:` / `chore:`
- 件名は 50 文字程度まで。詳細は本文に書く
- 本文には「なぜ必要だったか」「どういう問題が起きていたか」を書く
- 関連 Issue は `Refs #42`（PR マージ時に閉じる場合は PR 本文側に `Closes #42` を書く）
- `--no-verify` や `--amend` での履歴改変、`push --force` は**ユーザーの明示的な指示がない限り実行しない**

### 4. PR 粒度

**1 PR = 1 Issue** を原則とする。Issue が大きすぎて 1 PR に収まらない場合は、Issue を分割してから着手する。

- 独立した機能・修正を 1 つの PR に混ぜない（レビュー観点が分散し、部分ロールバックができなくなる）
- セキュリティ修正（#42〜#45）は特に**単独の PR**にする。他の変更と混ぜるとレビューの精度が落ちる
- 同時反映が避けられない場合のみ、PR 本文に含まれる全変更とその理由を明記する
- 目安として差分 400 行を超えたら分割を検討する

### 5. PR の作成

**最初は必ず Draft で作成する。** レビュー依頼可能な状態になってから Ready に変える。

本文は [`.github/pull_request_template.md`](.github/pull_request_template.md) に従う。`gh pr create` は `--body` を省略するとテンプレートを読み込まないため、テンプレートを埋めた内容を明示的に渡す。

```bash
gh pr create --base dev --draft \
  --title "fix: 企業情報のクエリを prepare 経由にする" \
  --body-file <埋めたテンプレートのパス>
```

- タイトルはコミットと同じ Conventional Commits 形式、70 文字以内
- 本文は日本語。テンプレートの項目を埋め、該当しない項目は行ごと削除する
- `Closes #<Issue番号>` を入れてマージ時に Issue が閉じるようにする
- PR に含まれる**全コミット**（`git log origin/dev..HEAD`）を確認してから本文を書く。最新コミットだけを見て書かない
- マージは squash を基本とする（作業途中のコミットを `dev` に残さない）

### 6. コミット・push・PR 作成のタイミング

`git commit` / `git push` / PR 作成は **ユーザーから明示的に依頼されたときのみ**実行する。実装が終わっただけでは自動でコミットしない。

## 実装ルール

### 変更は最小限に

依頼されていないリファクタリングを混ぜない。気づいた別の問題は、その場で直さず Issue に起こす。

### コメントの書き方

- コード: どう動くか（How）が読み取れるように書く
- コミットログ: なぜその変更をしたのか（Why）
- コードコメント: **なぜその実装を採用しなかったのか（Why not）**。次行の説明や変更の経緯は書かない

### WordPress プラグインとしての作法

このプラグインは他プラグイン・テーマと同じ PHP プロセスを共有する。グローバル空間を汚す変更は他サイトの機能を壊す。

- 新しく定義する定数・関数・グローバル変数には必ず `JOB_OPENING_` / `job_opening_` のプレフィックスを付ける（既存の `UPLOAD_DIR` / `console_log()` は Issue #51 / #52 で是正予定）
- 出力は必ずエスケープする（`esc_html()` / `esc_attr()` / `esc_url()`）
- DB クエリは必ず `$wpdb->prepare()` を通す
- POST を受け取る処理には nonce 検証（`check_admin_referer()` / `wp_verify_nonce()`）を入れる
- `wp_deregister_script()` や `single_template` フィルタのようにサイト全体へ影響するフックは、条件を必ず自プラグインの画面に限定する

### 動作確認

自動テストがないため、**実際に WordPress 上で動かして確認した内容を PR に書く**。「確認した」とだけ書かず、手順と結果を残す。

デモサイトの再生成が必要な変更（テンプレートの見た目変更など）は以下で確認する。

```bash
php tools/demo/generate.php   # docs/ 配下の静的サイトを再生成
node tools/demo/screenshot.mjs # スクリーンショットを撮り直す
```

詳細は [`tools/demo/README.md`](tools/demo/README.md) を参照。

### 検証していないことを「確認済み」と書かない

テストもリンタもない環境のため、実行して確かめていない挙動を断定しない。未検証の箇所は PR やコメントにその旨を明記する。

## 完了の定義

以下がすべて満たされて完了とする。

1. 対象 Issue の内容を満たしている
2. WordPress 上で動作確認し、その手順と結果を PR に記載した
3. 依頼範囲外の変更が混ざっていない
4. デバッグ用の `console_log()` / `var_dump()` / コメントアウトしたコードが残っていない
5. PR に `Closes #<Issue番号>` が記載されている
