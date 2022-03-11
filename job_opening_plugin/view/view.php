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
    $mode = strstr($url, 'action=');
    $mode = strstr($mode, '&', true);
    if ($mode) {
      $mode = explode("action=", $mode)[1];
    }

    $joid = strstr($url, 'post=');
    if ($joid) {
      $joid = explode("post=", $joid)[1];
    }

    if (!$mode && !$joid) {
      $html .= aaa($user);
    } else if ($mode == "edit") {
      $html .= editJob($user, $joid);
    }
  } else {
    $html .= "<strong>このページは閲覧できません．ログインしてください</strong>";
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
    $html .= "<strong>" . $user->display_name . "としてログインしています</strong>";

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
    $html .= "<strong>このページは閲覧できません．ログインしてください</strong>";
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
    $html .= "<strong>" . $user->display_name . "としてログインしています</strong>";
    // echo create_card($user);
    $html .= create_card($user);
  } else {
    $html .= "<strong>このページは閲覧できません．ログインしてください</strong>";
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
    $html .= "<strong>" . $user->display_name . "としてログインしています</strong>";
    // echo create_card($user);
    $html .= create_company($user);
  } else {
    $html .= "<strong>このページは閲覧できません．ログインしてください</strong>";
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
  $html .= bbb();
  $html .= bbb_foot();
  return $html;
}
