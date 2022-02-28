<?php
function create_company($user)
{
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['post_method'] == 'Y') {
    global $wpdb;
    $userId = $_POST['userId'];
    $co_name = $_POST['company_name'];
    $co_sector = $_POST['company_sector'];
    $co_url = $_POST['company_url'];
    $co_pr = $_POST['company_pr'];
    $co_zip_code = $_POST['company_zipcode'];
    $co_address = $_POST['company_address'];
    $co_achievement = $_POST['company_achievement'];
    $co_hour = $_POST['company_office_hour'];
    $co_benefits = $_POST['company_benefits'];
    $co_day_off = $_POST['company_day_off'];

    // セッションキーとチケットが一致しているどうか
    if ($_SESSION['key'] and $_POST['ticket'] and $_SESSION['key'] == $_POST['ticket']) {
      $wpdb->insert(
        $wpdb->prefix . 'sac_job_opening_companies',
        array(
          'co_name' => $co_name,
          'user_id' => $userId,
          'co_sector' => $co_sector,
          'co_url' => $co_url,
          'co_pr_point' => $co_pr,
          'co_zip_code' => $co_zip_code,
          'co_address' => $co_address,
          'co_achievement' => $co_achievement,
          'co_office_hours' => $co_hour,
          'co_employee_benefits' => $co_benefits,
          'co_day_off' => $co_day_off,
          'created_at' => current_time('mysql', 0)
        ),
        array('%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
      );
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

  //htmlの出力
  $action_url = str_replace('%7E', '~', $_SERVER['REQUEST_URI']);
  echo create_company_template($user, $action_url, $session_key);
}

// add_filter('the_content', 'page_form_sample');
