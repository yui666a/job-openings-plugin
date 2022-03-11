<?php

function create_card($user)
{
  // $post_id = wp_insert_post( array( 'post_title'=>'テスト投稿', 'post_content'=>'この投稿はテストです。' ) );
  console_log("create_card");
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['post_method'] == 'Y') {
    console_log("haitta");
    global $wpdb;
    $userId = $_POST['userId'];
    $company_id = $_POST['company_id'];
    $url = $_POST['url'];
    $position = $_POST['position'];
    $work_detail = $_POST['work_detail'];
    $working_conditions = $_POST['working_conditions'];
    $location = $_POST['location'];
    $remote_work = $_POST['remote_work'];
    $occupation = $_POST['occupation'];
    $date_period = $_POST['date_period'];
    $trip_period = $_POST['trip_period'];
    $trip_start = $_POST['trip_start'];
    $remote_work = $_POST['trip_last'];
    console_log("代入完了");
    // セッションキーとチケットが一致しているどうか
    if ($_SESSION['key'] and $_POST['ticket'] and $_SESSION['key'] == $_POST['ticket']) {
      console_log("セッション入った");
      $post = array(
        // 'ID'             => [ <投稿 ID> ] // 既存の投稿を更新する場合に指定。
        'post_content'   => $work_detail, // 投稿の全文。
        'post_name'      => $work_detail, // 投稿のスラッグ。
        'post_title'     => wp_strip_all_tags( $work_detail ), // 投稿のタイトル。
        // 'post_status'    => [ 'draft' | 'publish' | 'pending'| 'future' | 'private' | 登録済みカスタムステータス ],  // 公開ステータス。デフォルトは 'draft'。
        'post_status'    => 'publish', // 公開ステータス。デフォルトは 'draft'。
        'post_type'      => 'job_listing', // 投稿タイプ。デフォルトは 'post'。//  TODO: job_openingに変更
        // 'post_author'    => [ <ユーザー ID> ],  // 作成者のユーザー ID。デフォルトはログイン中のユーザーの ID。
        'ping_status'    => 'open', // 'open' ならピンバック・トラックバックを許可。デフォルトはオプション 'default_ping_status' の値。
        // 'post_parent'    => [ <投稿 ID> ],  // 親投稿の ID。デフォルトは 0。
        // 'menu_order'     => [ <順序値> ],  // 固定ページを追加する場合、メニュー内の並び順を指定。デフォルトは 0。
        // 'to_ping'        => // スペースまたは改行で区切った、ピンを打つ予定の URL のリスト。デフォルトは空文字列。
        // 'pinged'         => // スペースまたは改行で区切った、ピンを打った URL のリスト。デフォルトは空文字列。
        // 'post_password'  => [ <文字列> ],  // 投稿パスワード。デフォルトは空文字列。
        // 'guid'           => // 普通はこれを指定せず WordPress に任せてください。
        // 'post_content_filtered' => // 普通はこれを指定せず WordPress に任せてください。
        // 'post_excerpt'   => [ <文字列> ],  // 投稿の抜粋。
        // 'post_date'      => [ Y-m-d H:i:s ],  // 投稿の作成日時。date('Y-m-d H:i:s')
        // 'post_date_gmt'  => [ Y-m-d H:i:s ],  // 投稿の作成日時（GMT）。
        'comment_status' => 'closed',  // 'open' ならコメントを許可。デフォルトはオプション 'default_comment_status' の値、または 'closed'。
        // 'post_category'  => [ array(<カテゴリー ID>, ...) ],  // 投稿カテゴリー。デフォルトは空（カテゴリーなし）。
        // 'tags_input'     => [ '<tag>, <tag>, ...' | array ],  // 投稿タグ。デフォルトは空（タグなし）。
        // 'tax_input'      => [ array( <タクソノミー> => <array | string>, ...) ],  // カスタムタクソノミーとターム。デフォルトは空。
        // 'page_template'  => [ <文字列> ],  // テンプレートファイルの名前、例えば template.php 等。デフォルトは空。
      );
      console_log("配列完了");
      $wp_error= null;
      $post_id = wp_insert_post( $post, $wp_error );
      $message = '登録処理が完了しました';
    } else {
      $message = 'すでに送信済みです';
    }

    // セッションの破棄
    unset($_SESSION['key']);
    echo <<<EOF
    <div class="updated">
      <p><strong>{$message}</strong></p>
    </div>
EOF;
  }

  // ワンタイムチケットの生成とセッションへの保存
  $session_key = md5(sha1(uniqid(mt_rand(), true)));
  $_SESSION['key'] = $session_key;

  global $wpdb;
  $query = "SELECT * FROM `" . $wpdb->prefix . "sac_job_opening_companies` WHERE user_id=" . $user->ID . ";";
  $companies = $wpdb->get_results($query, OBJECT);

  //htmlの出力
  $action_url = str_replace('%7E', '~', $_SERVER['REQUEST_URI']);
  echo create_job_opening($user, $action_url, $session_key, $companies);
}
