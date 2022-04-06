<?php

//=================================================
// サブメニュー  ページ内容の表示・更新処理
//=================================================
/**
 * 求人一覧ページ用の関数
 */
function job_openings_list()
{
  global $wpdb;
  $user = wp_get_current_user();
  $html = "";
  if (
    current_user_can('administrator')
    || current_user_can('editor')
    || current_user_can('author')
    || current_user_can('contributor')
  ) {
    $mode = $_GET["action"];
    $joid = $_GET["post"];

    // ユーザとジョブIDの一致を検証する
    $post = get_post($joid, "ARRAY_A");
    $post_author = explode(" ", $post["post_author"])[0];

    if ($mode && $joid && ($user->ID == $post_author)) {
      if ($mode == "edit") {
        $html .= editJob($user, $joid);
      } else if ($mode == "copy") {
        $html .= editJob2($user, $joid);
      } else if ($mode == "draft") {
        wp_update_post([
          'ID'           => $joid,
          'post_status'   => 'draft',
        ]);
        $html .= jobTable($user);
      } else if ($mode == "publish") {
        wp_update_post([
          'ID'           => $joid,
          'post_status'   => 'publish',
        ]);
        $html .= jobTable($user);
      } else {
        $html .= '<strong>このページは閲覧できません．</strong>';
      }
    } else {
      $html .= jobTable($user);
    }
  } else {
    $html .= '<strong>このページは閲覧できません．ログインしてください</strong>
    <div><button class="button confirm" onclick="location.href=\''.wp_login_url(get_permalink()).'\'">ログイン画面へ</button></div>';
  }
  return $html;
}

/**
 * 企業一覧ページ用の関数
 */
function company_list()
{

  $user = wp_get_current_user();
  $html = "";
  if (
    current_user_can('administrator')
    || current_user_can('editor')
    || current_user_can('author')
    || current_user_can('contributor')
  ) {
    $mode = $_GET["action"];
    $co_id = $_GET["id"];

    // ユーザとジョブIDの一致を検証する
    $company = getCompanyById($co_id);
    if ($mode && $co_id && ($user->ID == $company->user_id)) {
      if ($mode == "edit") {
        $html .= editCompany($user, $co_id);
      } else if ($mode == "remove") {
        deleteCompaniesByCompanyId($co_id);
        $html .= companyTable($user);
      } else {
        $html .= '<strong>このページは閲覧できません．ログインしてください</strong>
        <div><button class="button confirm" onclick="location.href=\''.wp_login_url(get_permalink()).'\'">ログイン画面へ</button></div>';
      }
    } else {
      $html .= companyTable($user);
    }
  } else {
    $html .= '<strong>このページは閲覧できません．ログインしてください</strong>
    <div><button class="button confirm" onclick="location.href=\''.wp_login_url(get_permalink()).'\'">ログイン画面へ</button></div>';
  }

  return $html;
}

/**
 * 求人追加ページ用の関数
 */
function job_openings_add()
{
  $user = wp_get_current_user();
  $html = "";
  if (
    current_user_can('administrator')
    || current_user_can('editor')
    || current_user_can('author')
    || current_user_can('contributor')
  ) {
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
    $html .= "<strong>現在、" . $user->display_name . "としてログインしています(" . $loginout . "する)</strong>";
    $html .= create_card($user);
  } else {
    $html .= '<strong>このページは閲覧できません．ログインしてください</strong>
    <div><button class="button confirm" onclick="location.href=\''.wp_login_url(get_permalink()).'\'">ログイン画面へ</button></div>';
  }

  return $html;
}

/**
 * 企業追加ページ用の関数
 */
function company_add()
{
  $user = wp_get_current_user();
  $html = "";
  if (
    current_user_can('administrator')
    || current_user_can('editor')
    || current_user_can('author')
    || current_user_can('contributor')
  ) {
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
    $html .= "<strong>現在、" . $user->display_name . "としてログインしています(" . $loginout . "する)</strong>";
    $html .= create_company($user);
  } else {
    $html .= '<strong>このページは閲覧できません．ログインしてください</strong>
    <div><button class="button confirm" onclick="location.href=\''.wp_login_url(get_permalink()).'\'">ログイン画面へ</button></div>';
  }
  return $html;
}

/**
 * 設定ページ用の関数
 */
function settings()
{
  $user = wp_get_current_user();
}



/**
 * ユーザ画面 求人一覧ページ用の関数
 */
function user_job_openings()
{
  $html = "";
  $html .= userJobTable_head();

  $posts = getPublishedCard();
  global $post;
  foreach ($posts as $post) {
    setup_postdata($post);
    $post_id = get_the_ID();
    $job_expires = get_post_meta($post_id, '_expired_date', true);
    
    $today = date("Y/m/d");
    $target_day = $job_expires;
    if(strtotime($today) === strtotime($target_day)){
      // console_log("ターゲット日付は今日です");
      $html .= userJobTable($post_id);
    }else if(strtotime($today) < strtotime($target_day)){
      // console_log("ターゲット日付は未来です");
      $html .= userJobTable($post_id);
    }else{
      // 期限切れ
    }
  }

  $html .= userJobTable_foot();
  return $html;
}


//=================================================
// 管理画面（wp-adminページ用）
//=================================================
function job_openings_list_admin()
{
  if (current_user_can('administrator') || current_user_can('editor')) {
    echo job_openings_list();
  }
}

function company_list_admin()
{
  if (current_user_can('administrator') || current_user_can('editor')) {
    echo company_list();
  }
}

function job_openings_add_admin()
{
  echo job_openings_add();
}

function company_add_admin()
{
  echo company_add();
}
