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
      } else if ($mode == "draft") {
        wp_update_post([
          'ID'           => $joid,
          'post_status'   => 'draft',
        ]);
        $html .= aaa($user);
      } else if ($mode == "publish") {
        wp_update_post([
          'ID'           => $joid,
          'post_status'   => 'publish',
        ]);
        $html .= aaa($user);
      } else {
        $html .= '<strong>このページは閲覧できません．</strong>';
      }
    } else {
      $html .= aaa($user);
    }
  } else {
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
    $html .= '<strong>このページは閲覧できません．' . $loginout . 'してください</strong>';
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
    $company = getCompanyById($co_id)[0];
    if ($mode && $co_id && ($user->ID == $company->co_id)) {
      if ($mode == "edit") {
        $html .= editCompany($user, $co_id);
      } else {
        $html .= '<strong>このページは閲覧できません．</strong>';
      }
    } else {
      $html .= abab($user);
    }
  } else {
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
    $html .= '<strong>このページは閲覧できません．' . $loginout . 'してください</strong>';
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
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
    $html .= '<strong>このページは閲覧できません．' . $loginout . 'してください</strong>';
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
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
    $html .= '<strong>このページは閲覧できません．' . $loginout . 'してください</strong>';
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
  $html .= bbb_head();

  $posts = getPublishedCard();
  global $post;
  foreach ($posts as $post) {
    setup_postdata($post);
    $post_id = get_the_ID();
    $title = get_the_title();
    $author = get_the_author();
    $post_date = get_the_date();
    $permalink = get_permalink($post_id);
    $job_expires = get_post_meta($post_id, '_job_expires', true);
    $job_location = get_post_meta($post_id, '_job_location', true);

    $html .= bbb($post_id);
  }

  $html .= bbb_foot();
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
