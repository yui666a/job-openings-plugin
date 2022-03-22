<?php
function editCompany($user, $company_id)
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

    // セッションキーとチケットが一致しているどうか
    // if ($_SESSION['key'] and $_POST['ticket'] and $_SESSION['key'] == $_POST['ticket']) {
    if (true) {
      $query = array(
        'co_name' => $co_name,
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
      );
      $query_format = array('%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');

      // ファイル名を取得
      $filename = $_FILES['company_logo']['name'] . "_" . $userId;
      // move_uploaded_file（第1引数：ファイル名,第2引数：格納後のディレクトリ/ファイル名）
      $uploaded_path = UPLOAD_DIR["basedir"] . '/sac_jo/company_images/' . $filename;
      $result = move_uploaded_file($_FILES['company_logo']['tmp_name'], $uploaded_path);
      if ($result) {
        $co_logo = UPLOAD_DIR["baseurl"] . '/sac_jo/company_images/' . $filename;
        $query = array_merge($query, array('co_logo' => $co_logo));
        array_push($query_format, "%s");
      }


      $wpdb->update(
        $wpdb->prefix . 'sac_job_opening_companies',
        $query,
        array('co_id' => $company_id),
        $query_format,
        array('%d')
      );

      // 変更した企業の求人記事を書き直す
      $args = array(
        'post_type' => array('job_openings'),
        'offset' => 0,
        'post_status' => 'draft,publish,pending,future,private',
        'numberposts' => -1, //全件取得
        'author' => $user->ID
      );
      $posts = get_posts($args);
      foreach ($posts as $post) :
        setup_postdata($post);
        $post_id = $post->ID;
        $meta_company_id = get_post_meta($post_id, '_company_id', true);
        if ($meta_company_id == $company_id) {
          $post = get_post($post_id, "ARRAY_A");
          $company_id = get_post_meta($post_id, '_company_id', true);
          $recruitment_type =  get_post_meta($post_id, '_recruitment_type', true);
          $manage_id = get_post_meta($post_id, '_manage_id', true);
          $title = get_post_meta($post_id, '_title', true);
          $work_detail =  get_post_meta($post_id, '_work_detail', true);
          $application_conditions =  get_post_meta($post_id, '_application_conditions', true);
          $position = get_post_meta($post_id, '_position', true);
          $working_conditions = get_post_meta($post_id, '_working_conditions', true);
          $occupation = get_post_meta($post_id, '_occupation', true);
          $remote_work = get_post_meta($post_id, '_remote_work', true);
          $location = get_post_meta($post_id, '_location', true);
          $company = getCompanyById($company_id);
          $permalink = get_permalink($post_id);
          $zipcode = get_post_meta($post_id, '_zipcode', true);
          $address = get_post_meta($post_id, '_address', true);
          $address_2 = get_post_meta($post_id, '_address_2', true);
          // $company_salary,
          $apply_link = get_post_meta($post_id, '_apply_link', true);
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
            "date_period_type",
            "trip_period",
            "trip_start",
            "trip_last",
            $zipcode,
            $address,
            $address_2,
            // $company_salary,
            $apply_link
          );

          // データベースにある投稿を更新する
          wp_update_post([
            'ID'           => $post_id,
            'post_content' => $content
          ]);
        }
      endforeach;

      // 一覧ページに遷移する
      // header("Location:" . HOME_URL . "/" . get_option("sac_company_list"));
      // exit();
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
  return edit_company($user, $company_id, $action_url, $session_key);
}
