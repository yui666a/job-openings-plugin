<?php
/**
 * デモサイト（GitHub Pages 公開用）の生成スクリプト。
 *
 * WordPress の関数をスタブし、プラグイン本体のテンプレートをサンプルデータで
 * 描画して静的 HTML を出力する。モックの HTML を手書きするのではなく実際の
 * テンプレートを実行しているため、プラグインを修正すれば再生成でデモにも反映される。
 *
 * プラグイン本体のコードには一切手を加えない（読み取り専用でマウントする）。
 *
 * 実行方法は tools/demo/README.md を参照。
 */

$PLUGIN = getenv('PLUGIN_DIR') ?: '/plugin';
$OUT    = getenv('OUT_DIR') ?: '/out';

// ---- 定数（プラグイン本体が使うもの） ----
define('JOB_OPENING__PLUGIN_DIR', $PLUGIN . '/');
define('HOME_URL', 'https://example.com');
define('UPLOAD_DIR', ['basedir' => '/uploads', 'baseurl' => 'https://example.com/uploads']);

$_SERVER['REQUEST_URI']    = '/job_opening_list';
$_SERVER['REQUEST_METHOD'] = 'GET';

// ---- サンプルデータ ----
$COMPANIES = [
  (object)[
    'co_id' => 1, 'co_name' => '株式会社ながおか製作所', 'user_id' => 1, 'status' => 'active',
    'co_logo' => 'logo-a.svg',
    'co_url' => 'https://example.com/nagaoka',
    'co_summary' => '創業70年、精密板金加工を軸に medical・航空機分野へ展開する町工場です。',
    'co_pr_point' => '若手の裁量が大きく、入社2年目から設計を任されます。',
    'co_zip_code' => '940-0062', 'co_address' => '新潟県長岡市大手通1-4-10', 'co_address2' => 'ながおかビル3F',
    'co_sector' => '製造業（精密機械）', 'co_office_hours' => '8:30〜17:30（休憩60分）',
    'co_employee_benefits' => '各種社会保険完備／退職金制度／資格取得支援',
    'co_day_off' => '土日祝（年間休日121日）',
    'created_at' => '2026-04-02 10:15:00', 'updated_at' => '2026-07-28 14:02:11',
  ],
  (object)[
    'co_id' => 2, 'co_name' => '合同会社ヒルサイド・デザイン', 'user_id' => 1, 'status' => 'active',
    'co_logo' => 'logo-b.svg',
    'co_url' => 'https://example.com/hillside',
    'co_summary' => '地方企業のブランディングとWeb制作を手がけるデザインスタジオ。',
    'co_pr_point' => 'フルリモート可。副業・兼業も歓迎しています。',
    'co_zip_code' => '940-0088', 'co_address' => '新潟県長岡市柏町2-1-1', 'co_address2' => '',
    'co_sector' => 'Web・インターネット', 'co_office_hours' => 'フレックス（コアタイム11:00〜16:00）',
    'co_employee_benefits' => 'リモート手当／書籍購入補助／カンファレンス参加費支給',
    'co_day_off' => '完全週休二日制（年間休日125日）',
    'created_at' => '2026-05-20 09:00:00', 'updated_at' => '2026-08-01 18:45:30',
  ],
];

$POSTS = [
  101 => [
    'ID' => 101, 'post_title' => '精密板金の生産技術エンジニア（第二新卒歓迎）',
    'post_author' => 1, 'post_date' => '2026-07-15 09:00:00', 'post_status' => 'publish',
    'meta' => [
      '_company_id' => 1, '_manage_id' => 'NGO-2026-011', '_recruitment_type' => 'mid_career',
      '_title' => '精密板金の生産技術エンジニア（第二新卒歓迎）',
      '_occupation' => 'engineer', '_position' => '生産技術部',
      '_work_detail' => '<p>レーザー加工機・ベンダーを用いた精密板金の工程設計を担当します。CAD/CAMによる展開図作成から、治具設計、現場への落とし込みまで一貫して関わります。</p>',
      '_application_conditions' => '<p>機械・電気系の学科卒、または製造業での実務経験2年以上。CAD経験があれば尚可。</p>',
      '_working_conditions' => '<p>月給24〜34万円／賞与年2回／昇給年1回／時間外手当全額支給</p>',
      '_remote_work' => 'false', '_location' => '新潟県長岡市',
      '_zipcode' => '940-0062', '_address' => '新潟県長岡市大手通1-4-10', '_address_2' => '',
      '_apply_link' => 'https://example.com/apply/101',
      '_expired_date' => '2026-12-31', '_job_location' => '新潟県長岡市',
    ],
  ],
  102 => [
    'ID' => 102, 'post_title' => 'UIデザイナー（フルリモート可）',
    'post_author' => 1, 'post_date' => '2026-08-01 11:30:00', 'post_status' => 'publish',
    'meta' => [
      '_company_id' => 2, '_manage_id' => 'HSD-2026-003', '_recruitment_type' => 'both',
      '_title' => 'UIデザイナー（フルリモート可）',
      '_occupation' => 'creative', '_position' => 'デザイン部',
      '_work_detail' => '<p>自治体・地方企業のWebサイトおよびアプリのUI設計を担当します。ヒアリングから情報設計、プロトタイピングまで幅広く関わっていただきます。</p>',
      '_application_conditions' => '<p>Figmaを用いた実務経験1年以上。デザインシステム構築の経験がある方を歓迎します。</p>',
      '_working_conditions' => '<p>年俸400〜600万円／フルフレックス／リモート手当月1万円</p>',
      '_remote_work' => 'true', '_location' => '新潟県長岡市（フルリモート可）',
      '_zipcode' => '940-0088', '_address' => '新潟県長岡市柏町2-1-1', '_address_2' => '',
      '_apply_link' => 'recruit@example.com',
      '_expired_date' => '2026-11-30', '_job_location' => '新潟県長岡市',
    ],
  ],
  103 => [
    'ID' => 103, 'post_title' => '2027年度 新卒総合職（技術系）',
    'post_author' => 1, 'post_date' => '2026-06-10 08:00:00', 'post_status' => 'draft',
    'meta' => [
      '_company_id' => 1, '_manage_id' => 'NGO-2027-001', '_recruitment_type' => 'new_graduate',
      '_title' => '2027年度 新卒総合職（技術系）',
      '_occupation' => 'it_engineer', '_position' => '技術開発本部',
      '_work_detail' => '<p>入社後3か月の研修を経て、生産技術・品質保証・情報システムのいずれかに配属されます。</p>',
      '_application_conditions' => '<p>2027年3月までに四年制大学・大学院を卒業見込みの方。</p>',
      '_working_conditions' => '<p>初任給22万円／賞与年2回／寮完備</p>',
      '_remote_work' => 'both', '_location' => '新潟県長岡市',
      '_zipcode' => '940-0062', '_address' => '新潟県長岡市大手通1-4-10', '_address_2' => '',
      '_apply_link' => 'https://example.com/apply/103',
      '_expired_date' => '2027-03-31', '_job_location' => '新潟県長岡市',
    ],
  ],
];

// ---- WordPress 関数のスタブ ----
$post = null;

function console_log($d) {}
function console_error($d) {}

function get_option($k) {
  $map = [
    'sac_job_openings_list' => 'job_opening_list',
    'sac_company_list'      => 'company_list',
    'sac_job_openings_add'  => 'add_job_opening',
    'sac_company_add'       => 'add_company',
    'sac_user_job_openings' => 'user_job_openings',
    'home'                  => HOME_URL,
  ];
  return $map[$k] ?? '';
}

function wp_get_current_user() {
  return (object)['ID' => 1, 'display_name' => '長岡 太郎'];
}
function current_user_can($c) { return true; }
function wp_loginout($r = '', $e = true) { return '<a href="#">ログアウト</a>'; }
function wp_login_url($r = '') { return '/wp-login.php'; }
function get_permalink($id = 0) { return HOME_URL . '/job_openings/' . $id; }
function get_admin_url($b = '') { return HOME_URL . '/wp-admin/'; }
function esc_url($u) { return $u; }
function esc_attr($t) { return htmlspecialchars((string)$t, ENT_QUOTES, 'UTF-8'); }
function esc_html($t) { return htmlspecialchars((string)$t, ENT_QUOTES, 'UTF-8'); }
function wp_nonce_url($u, $a = -1) { return $u . '&_wpnonce=preview'; }
function wp_strip_all_tags($t) { return strip_tags((string)$t); }
function wp_reset_postdata() {}
function setup_postdata($p) {}
function current_time($t, $g = 0) { return date('Y-m-d H:i:s'); }
function plugin_dir_url($f) { return './'; }

function get_post($id, $out = OBJECT) {
  global $POSTS;
  $p = $POSTS[$id] ?? null;
  if (!$p) return null;
  $row = [
    'ID' => $p['ID'], 'post_title' => $p['post_title'], 'post_author' => $p['post_author'],
    'post_date' => $p['post_date'], 'post_status' => $p['post_status'],
  ];
  return $out === 'ARRAY_A' ? $row : (object)$row;
}
function get_post_meta($id, $key, $single = false) {
  global $POSTS;
  return $POSTS[$id]['meta'][$key] ?? '';
}
function get_post_status($id) {
  global $POSTS;
  return $POSTS[$id]['post_status'] ?? 'publish';
}
function get_the_ID() { global $post; return is_array($post) ? $post['ID'] : $post->ID; }
function get_the_title($id = 0) { global $post; return is_array($post) ? $post['post_title'] : $post->post_title; }
function get_the_author() { return '長岡 太郎'; }
function get_the_date($f = '') {
  global $post;
  $d = is_array($post) ? $post['post_date'] : $post->post_date;
  return date('Y年n月j日', strtotime($d));
}
function get_posts($args = []) {
  global $POSTS;
  $status = $args['post_status'] ?? 'publish';
  $out = [];
  foreach ($POSTS as $p) {
    if (strpos($status, $p['post_status']) === false) continue;
    $out[] = (object)[
      'ID' => $p['ID'], 'post_title' => $p['post_title'], 'post_author' => $p['post_author'],
      'post_date' => $p['post_date'], 'post_status' => $p['post_status'],
    ];
  }
  return $out;
}

// DB アクセス関数のスタブ（controller/company.php を読み込まず、同名で先に定義する）
function getCompanies() { global $COMPANIES; return $COMPANIES; }
function getCompaniesByUserId($uid) { global $COMPANIES; return $COMPANIES; }
function getCompanyById($id) {
  global $COMPANIES;
  foreach ($COMPANIES as $c) if ((int)$c->co_id === (int)$id) return $c;
  return $COMPANIES[0];
}
function getPublishedCard() {
  global $POSTS;
  $out = [];
  foreach ($POSTS as $p) {
    if ($p['post_status'] !== 'publish') continue;
    $out[] = (object)['ID' => $p['ID'], 'post_title' => $p['post_title'], 'post_date' => $p['post_date']];
  }
  return $out;
}

// ---- プラグイン本体のテンプレートを読み込む ----
$D = JOB_OPENING__PLUGIN_DIR;
require_once($D . 'util/dictionaries.php');
require_once($D . 'view/template/header.php');
require_once($D . 'view/template/addTags.php');
require_once($D . 'view/template/card.php');
require_once($D . 'view/template/notLogin.php');
require_once($D . 'view/template/jobTable.php');
require_once($D . 'view/template/companyTable.php');
require_once($D . 'view/template/userJobOpening.php');
require_once($D . 'view/template/addCard.php');
require_once($D . 'view/template/addCompany.php');
require_once($D . 'view/entryPage.php');
require_once($D . 'view/jobTable.php');
require_once($D . 'view/companyTable.php');

// ---- 各画面を描画 ----
$user = wp_get_current_user();

// 1. 入口ページ
$entry = entryPage();
// ローカルの同梱アイコンを参照させる（外部サイト参照を差し替え）
$entry = preg_replace('#https://nagaoka-worker\.jp/wp-content/uploads/2022/04/(icon-[a-z\-]+)\.png#', 'assets/$1.png', $entry);

/**
 * WordPress の固定ページ URL を、デモの静的ファイル名に置き換える。
 * 静的サイトには /add_company のようなパスが存在せず、そのままでは 404 になるため。
 */
function to_demo_links($html) {
  $map = [
    'add_company'      => 'add-company.html',
    'company_list'     => 'company-list.html',
    'add_job_opening'  => 'add-card.html',
    'job_opening_list' => 'job-list.html',
  ];
  foreach ($map as $slug => $file) {
    // 入口ページの「/add_company」形式と、ヘッダーの「https://example.com/add_company」形式の両方
    $html = preg_replace('#href="(?:' . preg_quote(HOME_URL, '#') . ')?/' . $slug . '"#', 'href="' . $file . '"', $html);
  }
  // 編集・コピーなどの操作リンクは静的サイトでは動作しないため、無効化する
  $html = preg_replace('#href="/job_opening_list\?[^"]*"#', 'href="#" onclick="return false" title="デモでは操作できません"', $html);
  return $html;
}

// 2. 求人一覧（管理）
$jobTable = jobTable($user);

// 3. 企業一覧（管理）
$coTable = companyTable($user);

// 4. 訪問者向け求人一覧
$userList = userJobTable_head();
foreach (getPublishedCard() as $p) {
  $post = $p;
  $userList .= userJobTable($p->ID);
}
$userList .= userJobTable_foot();

// 5. 求人 新規作成フォーム
$addCard = create_job_opening($user, '#', 'preview-ticket', $COMPANIES);

// 6. 企業 新規作成フォーム
$addCompany = create_company_template($user, '#', 'preview-ticket');

// ---- 出力 ----
function page($file, $title, $css, $body, $note = '', $js = false) {
  global $OUT;
  $links = '';
  foreach ($css as $c) $links .= "<link rel=\"stylesheet\" href=\"css/{$c}\" />\n  ";
  $scripts = '';
  if ($js) {
    // 実際のプラグインと同じ依存関係を読み込む（select2 が職種セレクタを構築する）
    $scripts = <<<JS
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script src="js/main.js"></script>
JS;
  }
  $links .= $scripts;
  $noteHtml = $note ? "<div class=\"demo-note\">{$note}</div>" : '';
  $nav = nav_html($file);
  $body = to_demo_links($body);
  $html = <<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{$title}｜Job Opening デモ</title>
  <meta name="description" content="WordPress プラグイン Job Opening の画面デモ。{$title}" />
  {$links}
  <style>
    body { background: #fff; margin: 0; padding: 0 0 4rem; font-family: -apple-system, "Hiragino Sans", "Noto Sans JP", sans-serif; }
    .demo-bar { background:#283b59; color:#fff; padding:.55rem 1rem; font-size:.85rem; display:flex; gap:.9rem; flex-wrap:wrap; align-items:center; position:sticky; top:0; z-index:999; }
    .demo-bar a { color:#fff; text-decoration:none; opacity:.72; }
    .demo-bar a:hover { opacity:1; text-decoration:underline; }
    .demo-bar a.on { opacity:1; font-weight:700; text-decoration:underline; }
    .demo-bar .t { font-weight:700; opacity:1; margin-right:.4rem; }
    .demo-bar .t a { opacity:1; }
    .demo-banner { background:#eef2f7; border-bottom:1px solid #d4dce6; color:#3d4a5c; padding:.5rem 1rem; font-size:.8rem; }
    .demo-note { background:#fff8e1; border-left:4px solid #f0b429; padding:.7rem 1rem; margin:1rem; font-size:.85rem; color:#5c4813; }
    .demo-note code { background:#f6ecd0; padding:.1em .35em; border-radius:3px; }
    .demo-body { padding: 1rem; }
  </style>
</head>
<body>
  <div class="demo-bar">
    <span class="t"><a href="index.html">Job Opening デモ</a></span>
    {$nav}
  </div>
  <div class="demo-banner">
    これは表示確認用のデモです。サンプルデータを表示しているだけで、保存・削除などの操作はできません。
  </div>
  {$noteHtml}
  <div class="demo-body">
{$body}
  </div>
</body>
</html>
EOF;
  file_put_contents("{$OUT}/{$file}", $html);
  echo "wrote {$file}\n";
}

/**
 * 画面間を行き来するナビゲーション。現在のページには .on を付ける。
 */
function nav_html($current) {
  $items = [
    'entry.html'        => '入口ページ',
    'add-company.html'  => '企業 新規作成',
    'company-list.html' => '企業一覧',
    'add-card.html'     => '求人 新規作成',
    'job-list.html'     => '求人一覧（管理）',
    'public-list.html'  => '求人一覧（訪問者向け）',
  ];
  $html = '';
  foreach ($items as $href => $label) {
    $on = ($href === $current) ? ' class="on"' : '';
    $html .= "<a href=\"{$href}\"{$on}>{$label}</a>\n    ";
  }
  return rtrim($html);
}

$formCss = ['normalize.css', 'style.css', 'header.css'];

page('entry.html', '入口ページ（マイページ）', ['normalize.css', 'entry.css'], $entry,
  '固定ページに <code>[entry_page]</code> を貼ると表示されます。投稿者が最初に開く入口で、ここから各画面に移動します。<br />デモではアイコンを同梱画像に差し替えています（プラグイン本体は外部サイトの画像を参照しているため）。');

page('add-company.html', '企業情報を作成', $formCss, $addCompany,
  '固定ページに <code>[company_add]</code> を貼ると表示されます。求人は企業に紐づくため、<strong>先に企業を登録します</strong>。郵便番号を入れると住所が自動入力されます。', true);

page('company-list.html', '作成した企業一覧', $formCss, $coTable,
  '固定ページに <code>[company_list]</code> を貼ると表示されます。自分が登録した企業だけが並び、編集・削除ができます。デモではサンプル企業2件を表示しています。');

page('add-card.html', '求人情報を作成', $formCss, $addCard,
  '固定ページに <code>[job_openings_add]</code> を貼ると表示されます。<strong>募集企業を選ぶと住所や就業時間が自動入力されます</strong>。職種は14分類から最大3つまで選べます。<br />仕事内容などの入力欄は、実際の環境ではリッチテキストエディタ（TinyMCE）になります。', true);

page('job-list.html', '作成した求人一覧（管理）', $formCss, $jobTable,
  '固定ページに <code>[job_openings_list]</code> を貼ると表示されます。公開・下書きの切り替え、編集、コピーして新規作成ができます。<br />デモではサンプル求人3件（公開2件・下書き1件）を表示しています。公開中の行は「非公開にする」、下書きの行は「公開する」と出し分けられます。');

page('public-list.html', '求人一覧（訪問者向け）', ['normalize.css', 'style.css', 'cardStyle.css'], $userList,
  '固定ページに <code>[user_job_openings]</code> を貼ると表示されます。これはサイト訪問者（求職者）が見る画面です。<br /><strong>公開済みかつ掲載期限内の求人だけ</strong>が新着順で並ぶため、上の管理画面にある下書き1件はここには出ません。');

// ---- トップページ ----
$index = <<<'EOF'
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Job Opening｜WordPress 求人投稿プラグインのデモ</title>
  <meta name="description" content="WordPress プラグイン Job Opening の画面デモ。管理画面を使わずフロントの固定ページから求人を投稿できます。" />
  <style>
    :root { --ink:#1f2937; --muted:#5b6775; --line:#e2e8f0; --navy:#283b59; --bg:#fff; --card:#fff; --accent:#f0b429; }
    @media (prefers-color-scheme: dark) {
      :root:not([data-theme="light"]) { --ink:#e8edf4; --muted:#a7b3c2; --line:#2c3a4d; --navy:#9db4d8; --bg:#141a22; --card:#1b232e; }
    }
    * { box-sizing: border-box; }
    body { margin:0; background:var(--bg); color:var(--ink); font-family:-apple-system,"Hiragino Sans","Noto Sans JP",sans-serif; line-height:1.75; }
    .wrap { max-width: 860px; margin: 0 auto; padding: 0 1.2rem 5rem; }
    header.hero { background:var(--navy); color:#fff; padding: 3rem 1.2rem 2.4rem; }
    @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) header.hero { background:#1c2836; } }
    .hero-inner { max-width: 860px; margin: 0 auto; }
    .hero h1 { margin:0 0 .5rem; font-size: 1.9rem; letter-spacing:.01em; }
    .hero p { margin:0; opacity:.9; font-size:1rem; max-width: 40em; }
    .badge { display:inline-block; background:rgba(255,255,255,.16); border-radius:99px; padding:.15rem .7rem; font-size:.75rem; margin-bottom:.9rem; }
    h2 { font-size:1.15rem; margin: 2.4rem 0 .3rem; padding-bottom:.4rem; border-bottom:2px solid var(--line); }
    .lead { color:var(--muted); font-size:.92rem; margin:.4rem 0 1.2rem; }
    .grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:.9rem; margin-top:1rem; }
    .card { display:block; border:1px solid var(--line); border-radius:10px; padding:1rem 1.1rem; text-decoration:none; color:inherit; background:var(--card); transition:.15s; }
    .card:hover { border-color:var(--navy); transform:translateY(-2px); box-shadow:0 4px 14px rgba(0,0,0,.07); }
    .card .step { font-size:.7rem; color:var(--muted); letter-spacing:.08em; text-transform:uppercase; }
    .card .name { font-weight:700; margin:.15rem 0 .3rem; }
    .card .desc { font-size:.83rem; color:var(--muted); line-height:1.6; }
    .card code { font-size:.78rem; background:rgba(128,128,128,.13); padding:.1em .35em; border-radius:3px; }
    .note { background:rgba(240,180,41,.11); border-left:4px solid var(--accent); padding:.85rem 1rem; border-radius:0 6px 6px 0; font-size:.87rem; margin:1.2rem 0; }
    ul.plain { padding-left:1.2rem; } ul.plain li { margin:.3rem 0; font-size:.92rem; }
    footer { margin-top:3rem; padding-top:1.2rem; border-top:1px solid var(--line); font-size:.83rem; color:var(--muted); }
    a { color:#2563eb; } @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) a { color:#7ab0ff; } }
  </style>
</head>
<body>
  <header class="hero">
    <div class="hero-inner">
      <span class="badge">WordPress プラグイン / 画面デモ</span>
      <h1>Job Opening</h1>
      <p>求人情報を企業単位で登録・掲載する WordPress プラグインです。WordPress の管理画面を開かなくても、サイト上の固定ページに置いたフォームから求人を投稿できます。</p>
    </div>
  </header>

  <div class="wrap">
    <div class="note">
      <strong>このデモについて</strong><br />
      プラグインが実際に出力する画面を、サンプルデータで表示しています。表示の確認だけができる状態で、保存・削除などの操作はできません。
    </div>

    <h2>投稿者が使う画面</h2>
    <p class="lead">求人を掲載する企業の担当者が使う画面です。番号の順に進みます。求人は企業に紐づくため、先に企業を登録します。</p>
    <div class="grid">
      <a class="card" href="entry.html">
        <div class="step">はじめに</div>
        <div class="name">入口ページ</div>
        <div class="desc">投稿者が最初に開くページ。ここから各画面に移動します。<br /><code>[entry_page]</code></div>
      </a>
      <a class="card" href="add-company.html">
        <div class="step">STEP 1</div>
        <div class="name">企業情報を作成</div>
        <div class="desc">社名・住所・就業時間などを登録します。郵便番号から住所を自動入力。<br /><code>[company_add]</code></div>
      </a>
      <a class="card" href="company-list.html">
        <div class="step">STEP 2</div>
        <div class="name">作成した企業一覧</div>
        <div class="desc">登録した企業の確認・編集・削除ができます。<br /><code>[company_list]</code></div>
      </a>
      <a class="card" href="add-card.html">
        <div class="step">STEP 3</div>
        <div class="name">求人情報を作成</div>
        <div class="desc">企業を選ぶと住所や就業時間が自動入力されます。職種は14分類から選択。<br /><code>[job_openings_add]</code></div>
      </a>
      <a class="card" href="job-list.html">
        <div class="step">STEP 4</div>
        <div class="name">作成した求人一覧</div>
        <div class="desc">公開・下書きの切り替え、編集、コピーして新規作成ができます。<br /><code>[job_openings_list]</code></div>
      </a>
    </div>

    <h2>サイト訪問者が見る画面</h2>
    <p class="lead">求職者に見せる公開ページです。公開済みかつ掲載期限内の求人だけが新着順で並びます。</p>
    <div class="grid">
      <a class="card" href="public-list.html">
        <div class="step">公開ページ</div>
        <div class="name">求人一覧（訪問者向け）</div>
        <div class="desc">掲載期限を過ぎた求人は自動的に一覧から外れます。<br /><code>[user_job_openings]</code></div>
      </a>
    </div>

    <h2>できること</h2>
    <ul class="plain">
      <li>WordPress の管理画面を使わず、固定ページのフォームから求人を投稿できる</li>
      <li>企業情報を一度登録すれば、以後の求人作成では選ぶだけで住所などが自動入力される</li>
      <li>掲載期間を「本日から〇日間」または開始日・終了日の指定で設定でき、期限切れは自動的に非表示になる</li>
      <li>投稿者ごとに、自分が作成した求人・企業のみ編集できる</li>
      <li>求人はカスタム投稿タイプとして保存されるため、テーマ側から通常の投稿と同様に扱える</li>
    </ul>

    <footer>
      導入手順や注意点は <a href="https://github.com/yui666a/job-openings-plugin#readme">README</a> を参照してください。<br />
      このデモページはプラグイン本体のテンプレートから自動生成しています（<code>tools/demo/</code>）。
    </footer>
  </div>
</body>
</html>
EOF;
file_put_contents("{$OUT}/index.html", $index);
echo "wrote index.html\n";
