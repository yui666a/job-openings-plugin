<?php
function create_company($user)
{
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['post_method'] == 'Y') {
    global $wpdb;
    $userId = $_POST['userId'];
    $co_logo = "";
    $co_name = $_POST['company_name'];
    $co_sector = $_POST['company_sector'];
    $co_url = $_POST['company_url'];
    $co_summary = $_POST['company_summary'];
    $co_pr = $_POST['company_pr'];
    $co_zip_code = $_POST['company_zipcode'];
    $co_address = $_POST['company_address'];
    $co_address2 = $_POST['company_address_2'];
    $co_hour = $_POST['company_office_hour'];
    $co_benefits = $_POST['company_benefits'];
    $co_day_off = $_POST['company_day_off'];

    // nonce が一致しているかどうか
    if (isset($_POST['ticket']) && wp_verify_nonce($_POST['ticket'], 'job_opening_create_company')) {
      // ロゴのアップロード（拡張子・MIME の検証、ファイル名のサニタイズは wp_handle_upload() に任せる）
      $uploaded = job_opening_handle_company_logo_upload(isset($_FILES['company_logo']) ? $_FILES['company_logo'] : array());
      if (isset($uploaded['error'])) {
        // ロゴなしで登録を続けると、失敗に気づかないまま企業が作られてしまうため登録しない
        $upload_error = $uploaded['error'];
      } elseif (isset($uploaded['url'])) {
        $co_logo = $uploaded['url'];
      }

      if (isset($upload_error)) {
        $message = 'ロゴのアップロードに失敗しました：' . esc_html($upload_error);
      } else {
        $wpdb->insert(
          $wpdb->prefix . 'sac_job_opening_companies',
          array(
            'co_name' => $co_name,
            'co_logo' => $co_logo,
            'user_id' => $userId,
            'co_sector' => $co_sector,
            'co_url' => $co_url,
            'co_summary' => $co_summary,
            'co_pr_point' => $co_pr,
            'co_zip_code' => $co_zip_code,
            'co_address' => $co_address,
            'co_address2' => $co_address2,
            'co_office_hours' => $co_hour,
            'co_employee_benefits' => $co_benefits,
            'co_day_off' => $co_day_off,
            'created_at' => current_time('mysql', 0)
          ),
          array('%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        // 一覧ページに遷移する
        header("Location:" . HOME_URL . "/" . get_option("sac_company_list"));
        exit();
      }
    } else {
      $message = '不正なリクエストです。お手数ですが、ページを開き直してもう一度お試しください。';
    }

    echo <<<EOF
    <div class="updated">
      <p><strong>{$message}</strong></p>
    </div>
EOF;
  }

  // nonce の生成
  $nonce = wp_create_nonce('job_opening_create_company');

  //htmlの出力
  $action_url = str_replace('%7E', '~', $_SERVER['REQUEST_URI']);
  return create_company_template($user, $action_url, $nonce);
}

