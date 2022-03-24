<?php

function editJob($user, $job_id)
{
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['post_method'] == 'Y') {

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
        // $company_salary,
        $apply_link
      );

      $post_id = $job_id;
      $updating_post = array(
        'ID'           => $job_id,
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'   => 'publish',
      );
      // データベースにある投稿を更新する
      wp_update_post($updating_post);

      update_post_meta($post_id, '_expired_date', $expired_date);
      update_post_meta($post_id, '_work_detail', $work_detail);
      update_post_meta($post_id, '_company_id', $company_id);
      update_post_meta($post_id, '_recruitment_type', $recruitment_type);
      update_post_meta($post_id, '_manage_id', $manage_id);
      update_post_meta($post_id, '_title', $title);
      update_post_meta($post_id, '_position', $position);
      update_post_meta($post_id, '_application_conditions', $application_conditions);
      update_post_meta($post_id, '_working_conditions', $working_conditions);
      update_post_meta($post_id, '_occupation', $occupation);
      update_post_meta($post_id, '_remote_work', $remote_work);
      update_post_meta($post_id, '_location', $location);
      update_post_meta($post_id, '_zipcode', $zipcode);
      update_post_meta($post_id, '_address', $address);
      update_post_meta($post_id, '_address_2', $address_2);
      // update_post_meta($post_id, '_company_salary', $company_salary);
      update_post_meta($post_id, '_apply_link', $apply_link);

      $message = '登録処理が完了しました（<a href="' . HOME_URL . "/" . get_option("sac_job_openings_list") . '">一覧にもどる</a>）';
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
  return edit_job_opening($user, $action_url, $session_key, $companies, $job_id);
}
