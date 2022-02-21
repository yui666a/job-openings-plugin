<?php

/**
 * @package job_opening_plugin
 * @version 0.1
 */
/*
Plugin Name: Job Opening
Plugin URI: https://github.com/yui666a/job-openings-plugin
Description: TODO　求人情報を簡易登録可能なプラグイン
Version: 0.1
Author: yui666a
Author URI: https://yui666a.github.io/home/
*/


//=================================================
// 管理画面に「とりあえずメニュー」を追加登録する
//=================================================
add_action('admin_menu', function () {

  //---------------------------------
  // メインメニュー
  //---------------------------------
  add_menu_page(
    '求人簡易投稿', // ページのタイトルタグ<title>に表示されるテキスト
    '求人簡易投稿',   // 左メニューとして表示されるテキスト
    'manage_options',       // 必要な権限 manage_options は通常 administrator のみに与えられた権限
    'job-openings',        // 左メニューのスラッグ名 →URLのパラメータに使われる
    '', // メニューページを表示する際に実行される関数
    'dashicons-media-document',       // メニューのアイコンを指定 https://developer.wordpress.org/resource/dashicons/#awards
    99                             // メニューが表示される位置のインデックス(0が先頭)
  );

  //---------------------------------
  // サブメニュー
  //---------------------------------
  add_submenu_page(
    'job-openings',    // 親メニューのスラッグ
    '求人情報一覧', // ページのタイトルタグ<title>に表示されるテキスト
    '求人情報一覧', // サブメニューとして表示されるテキスト
    'manage_options', // 必要な権限 manage_options は通常 administrator のみに与えられた権限
    'job-openings',  // サブメニューのスラッグ名。この名前を親メニューのスラッグと同じにすると親メニューを押したときにこのサブメニューを表示します。一般的にはこの形式を採用していることが多い。
    'job_openings_list', //（任意）このページのコンテンツを出力するために呼び出される関数
    0
  );

  add_submenu_page(
    'job-openings',    // 親メニューのスラッグ
    '新規作成', // ページのタイトルタグ<title>に表示されるテキスト
    '新規作成', // サブメニューとして表示されるテキスト
    'manage_options', // 必要な権限 manage_options は通常 administrator のみに与えられた権限
    'job-openings-add-card', //サブメニューのスラッグ名
    'job_openings_add', //（任意）このページのコンテンツを出力するために呼び出される関数
    1
  );
});

/**
 * (未使用) メインメニューページ内容の表示・更新処理
 * @deprecated version 0.1
 */
function toriaezu_mainmenu_page_contents()
{
  // HTML表示
  echo <<<EOF
<div class="wrap">
	<h2>メインメニュー</h2>
	<p>
    job-openingsのページです。
	</p>
</div>
EOF;
}


//=================================================
// サブメニュー①ページ内容の表示・更新処理
//=================================================
function job_openings_list()
{

  //---------------------------------
  // HTML表示
  //---------------------------------
  echo <<<EOF


<div class="wrap">
	<h2>サブメニュー②</h2>
	<p>
		求人情報追加 のページです。
	</p>
</div>

EOF;
}

//=================================================
// サブメニュー②ページ内容の表示・更新処理
//=================================================

function job_openings_add()
{

  //---------------------------------
  // ユーザーが必要な権限を持つか確認
  //---------------------------------
  if (!current_user_can('manage_options')) {
    wp_die(__('この設定ページのアクセス権限がありません'));
  }

  //---------------------------------
  // 初期化
  //---------------------------------
  $opt_name = 'toriaezu_message'; //オプション名の変数
  $opt_val = get_option($opt_name); // 既に保存してある値があれば取得
  $opt_val_old = $opt_val;
  $message_html = "";

  //---------------------------------
  // 更新されたときの処理
  //---------------------------------
  if (isset($_POST[$opt_name])) {

    // POST されたデータを取得
    $opt_val = $_POST[$opt_name];

    // POST された値を$opt_name=$opt_valでデータベースに保存(wp_options テーブル内に保存)
    update_option($opt_name, $opt_val);

    // 画面にメッセージを表示
    $message_html = <<<EOF

<div class="notice notice-success is-dismissible">
	<p>
		メッセージを保存しました
		({$opt_val_old}→{$opt_val})
	</p>
</div>

EOF;
  }

  //---------------------------------
  // HTML表示
  //---------------------------------
  echo $html = <<<EOF

{$message_html}

<div class="wrap">
	<h2>とりあえずメニューページ</h2>
	<form name="form1" method="post" action="">
		<p>
			<input type="text" name="{$opt_name}" value="{$opt_val}" size="32" placeholder="メッセージを入力してみて下さい">
		</p>
		<hr />
		<p class="submit">
			<input type="submit" name="submit" class="button-primary" value="メッセージを保存" />
		</p>
	</form>
</div>

EOF;
}