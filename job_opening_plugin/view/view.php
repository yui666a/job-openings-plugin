<?php

include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/jobTable.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/addCard.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/addCompany.php');


/**
 * (未使用) メインメニューページ内容の表示・更新処理
 * @deprecated version 0.1
 */
function main_menu_page_contents() {
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
function job_openings_list() {
  $args = array(
    'post_type' => 'post',  // 投稿タイプ
    // 'category_name' => 'カテゴリのスラッグ',	// 絞り込むカテゴリ
    // 'tag' => 'タグスラッグ',	// 絞り込むタグ
    // 's' => '検索文字列',	// 検索文字列
    // 'posts_per_page' => 3,	// 表示件数
    // 'post_status' => 'publish',	// 公開済みのみ
    'post_type' => 'job_listing',
    'orderby' => 'date',  //新着順
    'order' => 'ASC',  // 昇順
  );

  query_posts($args);
  // $posts_array = get_posts($args);

  echo make_job_openings_table_head();
  // ループ
  if (have_posts()) :
    echo '<tbody id="the-list">';
    while (have_posts()) :
      the_post();
      echo make_job_openings_table_row(the_title());
    endwhile;
    echo '</tbody>';
  endif;
  echo make_job_openings_table_foot();
  // 投稿データのリセット
  wp_reset_query();
}

function company_list() {
  $args = array(
    'post_type' => 'post',  // 投稿タイプ
    // 'category_name' => 'カテゴリのスラッグ',	// 絞り込むカテゴリ
    // 'tag' => 'タグスラッグ',	// 絞り込むタグ
    // 's' => '検索文字列',	// 検索文字列
    // 'posts_per_page' => 3,	// 表示件数
    // 'post_status' => 'publish',	// 公開済みのみ
    'post_type' => 'job_listing',
    'orderby' => 'date',  //新着順
    'order' => 'ASC',  // 昇順
  );

  query_posts($args);
  // $posts_array = get_posts($args);

  echo make_job_openings_table_head();
  // ループ
  if (have_posts()) :
    echo '<tbody id="the-list">';
    while (have_posts()) :
      the_post();
      echo make_job_openings_table_row(the_title());
    endwhile;
    echo '</tbody>';
  endif;
  echo make_job_openings_table_foot();
  // 投稿データのリセット
  wp_reset_query();
}

function job_openings_add() {
  echo create_job_opening();
}

function company_add() {
  echo create_company();
}


//=================================================
// サブメニュー②ページ内容の表示・更新処理
//=================================================
function job_openings_TODO() {

  //---------------------------------
  // ユーザーが必要な権限を持つか確認
  //---------------------------------
  if (!current_user_can('manage_options')) {
    wp_die(__('この設定ページのアクセス権限がありません'));
  }

  //---------------------------------
  // 初期化
  //---------------------------------
  $opt_name = 'hoge'; //オプション名の変数
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
