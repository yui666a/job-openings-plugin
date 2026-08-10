# デモサイトの生成

`docs/` 配下の静的デモサイトを生成するスクリプトです。生成物は GitHub Pages で公開されます。

https://yui666a.github.io/job-openings-plugin/

## 仕組み

`generate.php` が WordPress の関数（`get_post_meta`、`wp_get_current_user` など）をスタブし、**プラグイン本体のテンプレートをそのまま実行**してサンプルデータで描画します。

モックの HTML を手書きしているわけではないため、`job_opening_plugin/view/` 配下を修正して再生成すれば、その変更がデモにも反映されます。プラグイン本体のコードは読み取り専用でマウントしており、生成時に変更されることはありません。

## 生成方法

PHP がローカルにあれば直接実行できます。

```sh
PLUGIN_DIR=job_opening_plugin OUT_DIR=docs php tools/demo/generate.php
```

PHP が無い場合は Docker で実行します。

```sh
docker run --rm \
  -v "$PWD/job_opening_plugin":/plugin:ro \
  -v "$PWD/docs":/out \
  -v "$PWD/tools/demo/generate.php":/generate.php:ro \
  php:8.2-cli php /generate.php
```

CSS・画像・JS は `job_opening_plugin/` からコピーする必要があります。

```sh
cp job_opening_plugin/css/*.css docs/css/
cp job_opening_plugin/img/*.png docs/assets/
cp job_opening_plugin/js/main.js job_opening_plugin/js/companyAutoInput.js docs/js/
```

## 生成されるファイル

| ファイル | 内容 |
| --- | --- |
| `index.html` | トップページ（デモの入口・機能説明） |
| `entry.html` | 入口ページ `[entry_page]` |
| `add-company.html` | 企業情報を作成 `[company_add]` |
| `company-list.html` | 作成した企業一覧 `[company_list]` |
| `add-card.html` | 求人情報を作成 `[job_openings_add]` |
| `job-list.html` | 作成した求人一覧 `[job_openings_list]` |
| `public-list.html` | 求人一覧（訪問者向け）`[user_job_openings]` |

## デモ用に実物と変えている点

静的な HTML として成立させるため、以下だけ実際の動作と異なります。

- **企業ロゴ** — サンプル企業のロゴとして `logo-a.svg` / `logo-b.svg` を用意している
- **入口ページのアイコン** — プラグイン本体は外部サイト（`nagaoka-worker.jp`）の画像を直接参照しているが、デモでは同梱の `job_opening_plugin/img/` を参照するよう置換している
- **フォームの送信** — 静的サイトのため保存・削除はできない
- **本文エディタ** — 実環境では TinyMCE が起動するが、デモでは通常の `textarea` のまま

サンプルデータ（企業2件・求人3件）は `generate.php` の `$COMPANIES` と `$POSTS` に定義しています。

## ローカルでの確認

```sh
cd docs && python3 -m http.server 8899
```
