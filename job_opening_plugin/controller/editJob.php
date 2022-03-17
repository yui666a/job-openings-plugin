<?php

function editJob($user, $job_id)
{
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['post_method'] == 'Y') {
    $post_status = "";
    if ($_POST['action'] == 'update') {
      $post_status = "publish";
    } else if ($_POST['action'] == 'draft') {
      $post_status = "draft";
    }

    global $wpdb;
    $userId = $_POST['userId'];
    $company_id = $_POST['company_id'];
    $recruitment_type = $_POST['recruitment_type'];
    $url = $_POST['url'];
    $title = $_POST['title'];
    $position = $_POST['position'];
    $work_detail = $_POST['work_detail'];
    $application_conditions = $_POST['application_conditions'];
    $working_conditions = $_POST['working_conditions'];
    $location = $_POST['location'];
    $remote_work = $_POST['remote_work'];
    $occupation = $_POST['occupation'];
    $date_period_type = $_POST['date_period_type'];
    $trip_period = $_POST['trip_period'];
    $trip_start = $_POST['trip_start'];
    $trip_last = $_POST['trip_last'];

    // セッションキーとチケットが一致しているどうか
    if ($_SESSION['key'] and $_POST['ticket'] and $_SESSION['key'] == $_POST['ticket']) {
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


      $co_data = getCompanyById($company_id)[0];
      $content = create_job_openingssss(
        $company_id,
        $recruitment_type ,
        $title ,
        $url ,
        $position ,
        $work_detail ,
        $application_conditions ,
        $working_conditions ,
        $location ,
        $remote_work ,
        $occupation ,
        $date_period_type ,
        $trip_period ,
        $trip_start ,
        $trip_last
      );

      $post_id = $job_id;
      // TODO: postのアップデート
      update_post_meta($post_id, '_expired_date', $expired_date);
      update_post_meta($post_id, '_work_detail', $work_detail);
      update_post_meta($post_id, '_company_id', $company_id);
      update_post_meta($post_id, '_recruitment_type', $recruitment_type);
      update_post_meta($post_id, '_url', $url);
      update_post_meta($post_id, '_title', $title);
      update_post_meta($post_id, '_position', $position);
      update_post_meta($post_id, '_application_conditions', $application_conditions);
      update_post_meta($post_id, '_working_conditions', $working_conditions);
      update_post_meta($post_id, '_occupation', $occupation);
      update_post_meta($post_id, '_remote_work', $remote_work);
      update_post_meta($post_id, '_location', $location);

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
    $session_key = md5(sha1(uniqid(mt_rand(), true)));
    $_SESSION['key'] = $session_key;
  }

  // ワンタイムチケットの生成とセッションへの保存
  $session_key = md5(sha1(uniqid(mt_rand(), true)));
  $_SESSION['key'] = $session_key;

  global $wpdb;
  $query = "SELECT * FROM `" . $wpdb->prefix . "sac_job_opening_companies` WHERE user_id=" . $user->ID . ";";
  $companies = $wpdb->get_results($query, OBJECT);

  //htmlの出力
  $action_url = str_replace('%7E', '~', $_SERVER['REQUEST_URI']);
  return edit_job_opening($user, $action_url, $session_key, $companies, $job_id);
}
