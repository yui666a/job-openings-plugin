<?php

//=================================================
// サブメニュー  ページ内容の表示・更新処理
//=================================================
/**
 * 求人一覧ページ用の関数
 */
function job_openings_list()
{
  $user = wp_get_current_user();
  $html = "";
  if (
    current_user_can('administrator')
    || current_user_can('editor')
    || current_user_can('author')
    || current_user_can('contributor')
  ) {
    $url = $_SERVER['REQUEST_URI'];
    $mode = $_GET["action"];
    $joid = $_GET["post"];

    if (!$mode && !$joid) {
      $html .= aaa($user);
    } else if ($mode == "edit") {
      $html .= editJob($user, $joid);
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
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
    $html .= "<strong>現在、" . $user->display_name . "としてログインしています(".$loginout."する)</strong>";

    global $wpdb;
    $query = "SELECT * FROM `" . $wpdb->prefix . "sac_job_opening_companies` WHERE user_id=" . wp_get_current_user()->ID . ";";
    $companies = $wpdb->get_results($query, OBJECT);

    // 表 ヘッダーの表示
    $html .=  make_company_table_head();

    $html .=  '<tbody id="the-list">';
    // ob_start();
    foreach ($companies as $data) :
      $html .=  make_company_table_row($data);
    endforeach;
    $html .=  '</tbody>';

    // 表 フッターの表示
    $html .=  make_company_table_head();
    // ob_get_clean();
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
    $html .= "<strong>現在、" . $user->display_name . "としてログインしています(".$loginout."する)</strong>";    // echo create_card($user);
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
    $html .= "<strong>現在、" . $user->display_name . "としてログインしています(".$loginout."する)</strong>";
    // echo create_card($user);
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
  // echo create_company($user);
}



/**
 * 企業追加ページ用の関数
 */
function user_job_openings()
{
  $html = "";
  $html .= bbb_head();

  $posts = getPublishedCard();
  foreach ($posts as $post) {
    setup_postdata($post);
    $post_id = get_the_ID();
    $title = get_the_title();
    $author = get_the_author();
    $post_date = get_the_date();
    $permalink = get_permalink($post_id);
    $job_expires = get_post_meta($post_id, '_job_expires', true);
    $job_location = get_post_meta($post_id, '_job_location', true);

    $html .= bbb();
  }

  $html .= bbb_foot();
  return $html;
}
