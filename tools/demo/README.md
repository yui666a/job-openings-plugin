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

## スクリーンショット

ルートの `README.md` に載せているスクリーンショットは `docs/screenshots/` に置いています。`screenshot.mjs` が公開中のデモサイトを撮影したもので、撮影時にデモ用のヘッダー・バナー・注釈（`.demo-bar` / `.demo-banner` / `.demo-note`）は非表示にしています。

画面のデザインを変更した場合は、デモを再生成したうえで撮り直してください。

ヘッドレス Chrome を CDP で操作するだけなので、追加のパッケージは不要です（Node.js 22 以上）。

```sh
# 1. ヘッドレス Chrome を起動する
#    パスは Playwright / Puppeteer が入れた Chromium などに読み替えてください
chrome-headless-shell --headless --disable-gpu \
  --remote-debugging-port=9333 --user-data-dir=/tmp/cdp-profile about:blank &

# 2. 撮影する
OUT=docs/screenshots node tools/demo/screenshot.mjs
```

ローカルで生成した `docs/` を撮る場合は `BASE` を指定します。

```sh
cd docs && python3 -m http.server 8899 &
BASE=http://localhost:8899 OUT=docs/screenshots node tools/demo/screenshot.mjs
```

### ビューポート幅について

`screenshot.mjs` の `SHOTS` には画面ごとにビューポート幅を持たせています。

プラグインの CSS は `.contents-header-wrapper` が `width: 100%` と `padding: 2rem 4%` を併用しており、`box-sizing` が指定されていないため内容が必ず横に溢れます。溢れた状態で撮ると右端が切れるため、各画面が収まる幅を指定しています。画面を修正して幅が変わった場合はこの値も調整してください。

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
