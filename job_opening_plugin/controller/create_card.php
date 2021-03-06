<?php

function create_card($user)
{
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['post_method'] == 'Y') {
    $post_status = "";
    if ($_POST['action'] == 'post') {
      $post_status = "publish";
    } else if ($_POST['action'] == 'draft') {
      $post_status = "draft";
    }

    global $wpdb;
    $company_id = $_POST['company_id']; // 企業
    $title = $_POST['title']; // 求人タイトル
    $apply_link = $_POST['apply_link']; // 応募URLや宛先メールアドレス
    $manage_id = $_POST['manage_id']; // 求人管理
    $recruitment_type = $_POST['recruitment_type']; // 求人タイプ
    $occupation = $_POST['occupation']; // 職種
    $position = $_POST['position']; // 部署・役職名
    $work_detail = $_POST['work_detail']; // 仕事内容
    $application_conditions = $_POST['application_conditions']; // 募集要件
    $working_conditions = $_POST['working_conditions']; // 労働条件
    $location = $_POST['location']; // 勤務地
    $remote_work = $_POST['remote_work']; // リモートワーク
    $zipcode = $_POST['zipcode']; // 勤務地 郵便番号
    $address = $_POST['address']; // 勤務地 住所
    $address_2 = $_POST['address_2']; // 勤務地 住所2
    $date_period_type = $_POST['date_period_type']; // 掲載期間選択タイプ
    $trip_period = $_POST['trip_period']; // 日数
    $trip_start = $_POST['trip_start']; // 掲載開始月日
    $trip_last = $_POST['trip_last']; // 掲載終了月日

    // セッションキーとチケットが一致しているどうか
    // if ($_SESSION['key'] and $_POST['ticket'] and $_SESSION['key'] == $_POST['ticket']) {
    if (true) {
      if ($date_period_type == "period") {
        $date = new DateTime();
        $post_date = $date->format('Y-m-d H:i:s'); // 投稿日
        $date->modify('+' . $trip_period . ' day'); // 掲載終了日
        $expired_date = $date->format('Y-m-d');
      } else {
        $date = new DateTime($trip_start);
        $post_date = $date->format('Y-m-d H:i:s'); // 投稿日
        $expired_date = $trip_last; // 掲載終了日
      }

      $content = create_job_openingssss(
        $company_id,
        $recruitment_type,
        $title,
        $manage_id,
        $position,
        $work_detail,
        $application_conditions,
        $working_conditions,
        $location,
        $remote_work,
        $occupation,
        $date_period_type,
        $trip_period,
        $trip_start,
        $trip_last,
        $zipcode,
        $address,
        $address_2,
        $apply_link
      );

      $post = array(
        // 'ID'             => [ <投稿 ID> ] // 既存の投稿を更新する場合に指定。
        'post_content'   => $content, // 投稿の全文。
        'post_name'      => $title, // 投稿のスラッグ。
        'post_title'     => wp_strip_all_tags($title), // 投稿のタイトル。
        // 'post_status'    => [ 'draft' | 'publish' | 'pending'| 'future' | 'private' | 登録済みカスタムステータス ],  // 公開ステータス。デフォルトは 'draft'。
        'post_status'    => $post_status, // 公開ステータス。デフォルトは 'draft'。
        'post_type'      => 'job_openings', // 投稿タイプ。デフォルトは 'post'
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
        'post_date'      => $post_date,  // 投稿の作成日時。date('Y-m-d H:i:s')
        // 'post_date_gmt'  => [ Y-m-d H:i:s ],  // 投稿の作成日時（GMT）。
        'comment_status' => 'closed',  // 'open' ならコメントを許可。デフォルトはオプション 'default_comment_status' の値、または 'closed'。
        'post_category'  => "job_openings",  // 投稿カテゴリー。デフォルトは空（カテゴリーなし）。
        // 'tags_input'     => [ '<tag>, <tag>, ...' | array ],  // 投稿タグ。デフォルトは空（タグなし）。
        // 'tax_input'      => [ array( <タクソノミー> => <array | string>, ...) ],  // カスタムタクソノミーとターム。デフォルトは空。
        // 'page_template'  => [ <文字列> ],  // テンプレートファイルの名前、例えば template.php 等。デフォルトは空。
      );

      $wp_error = null;
      $post_id = wp_insert_post($post, $wp_error);
      add_post_meta($post_id, '_expired_date', $expired_date);
      add_post_meta($post_id, '_work_detail', $work_detail);
      add_post_meta($post_id, '_company_id', $company_id);
      add_post_meta($post_id, '_recruitment_type', $recruitment_type);
      add_post_meta($post_id, '_manage_id', $manage_id);
      add_post_meta($post_id, '_title', $title);
      add_post_meta($post_id, '_position', $position);
      add_post_meta($post_id, '_application_conditions', $application_conditions);
      add_post_meta($post_id, '_working_conditions', $working_conditions);
      add_post_meta($post_id, '_occupation', $occupation);
      add_post_meta($post_id, '_remote_work', $remote_work);
      add_post_meta($post_id, '_location', $location);
      add_post_meta($post_id, '_zipcode', $zipcode);
      add_post_meta($post_id, '_address', $address);
      add_post_meta($post_id, '_address_2', $address_2);
      add_post_meta($post_id, '_apply_link', $apply_link);

      // 一覧ページに遷移する
      header("Location:" . HOME_URL . "/" . get_option("sac_job_openings_list"));
      exit();
      // $message = '登録処理が完了しました';
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

  $companies = getCompaniesByUserId($user->ID);

  //htmlの出力
  $action_url = str_replace('%7E', '~', $_SERVER['REQUEST_URI']);
  return create_job_opening($user, $action_url, $session_key, $companies);
}
