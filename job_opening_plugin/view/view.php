<?php

/**
 * このプラグインの求人・企業情報を操作できるかを判定する
 *
 * ロール名を current_user_can() に渡す書き方は公式に「discouraged」とされているため使わない。
 * edit_posts を持つのは administrator / editor / author / contributor で、subscriber は持たない。
 * 従来のロール名の羅列と許可範囲が一致する。
 */
function job_opening_current_user_can_manage()
{
  return current_user_can('edit_posts');
}

/**
 * GET リンクに付与した nonce を検証する
 *
 * check_admin_referer() は検証に失敗すると wp_nonce_ays() を出して die() するため、
 * 固定ページのショートコードから呼ぶこのプラグインでは使わない。ページ全体の描画が
 * 途中で止まってしまう。
 */
function job_opening_verify_get_nonce($action)
{
  return isset($_GET['ticket']) && wp_verify_nonce($_GET['ticket'], $action);
}

//=================================================
// サブメニュー  ページ内容の表示・更新処理
//=================================================
/**
 * 求人一覧ページ用の関数
 */
function entry_page()
{
  $user = wp_get_current_user();
  $html = "";
  if (job_opening_current_user_can_manage()) {
    // ユーザとジョブIDの一致を検証する
    $html .= entryPage();
  } else {
    $html .= notLogin();
  }
  return $html;
}


/**
 * 求人一覧ページ用の関数
 */
function job_openings_list()
{
  global $wpdb;
  $user = wp_get_current_user();
  $html = "";
  if (job_opening_current_user_can_manage()) {
    $mode = isset($_GET["action"]) ? $_GET["action"] : "";
    // 数値以外は 0 になり存在しない投稿として扱えるため、get_post() に到達する前に弾ける
    $joid = isset($_GET["post"]) ? absint($_GET["post"]) : 0;

    if (!$mode || !$joid) {
      // パラメータなしのアクセスは通常の一覧表示
      $html .= jobTable($user);
    } else {
      // ユーザとジョブIDの一致を検証する
      $post = get_post($joid, "ARRAY_A");
      $post_author = $post ? (int) $post["post_author"] : 0;

      if ($post && ((int) $user->ID === $post_author)) {
        if ($mode == "edit") {
          $html .= editJob($user, $joid);
        } else if ($mode == "copy") {
          $html .= editJob2($user, $joid);
        } else if ($mode == "draft" && job_opening_verify_get_nonce('job_opening_draft_job_' . $joid)) {
          wp_update_post([
            'ID'           => $joid,
            'post_status'   => 'draft',
          ]);
          $html .= jobTable($user);
        } else if ($mode == "publish" && job_opening_verify_get_nonce('job_opening_publish_job_' . $joid)) {
          wp_update_post([
            'ID'           => $joid,
            'post_status'   => 'publish',
          ]);
          $html .= jobTable($user);
        } else {
          $html .= job_opening_forbidden();
        }
      } else {
        // 所有者でない求人の操作は一覧に落とさず拒否を伝える
        $html .= job_opening_forbidden();
      }
    }
  } else {
    $html .= notLogin();
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
  if (job_opening_current_user_can_manage()) {
    $mode = isset($_GET["action"]) ? $_GET["action"] : "";
    // 数値以外は 0 になり該当レコードが引けないため、SQL に到達する前に弾ける
    $co_id = isset($_GET["id"]) ? absint($_GET["id"]) : 0;

    if (!$mode || !$co_id) {
      // パラメータなしのアクセスは通常の一覧表示
      $html .= companyTable($user);
    } else {
      // ユーザとジョブIDの一致を検証する
      $company = getCompanyById($co_id);

      if ($company && ((int) $user->ID === (int) $company->user_id)) {
        if ($mode == "edit") {
          $html .= editCompany($user, $co_id);
        } else if ($mode == "remove" && job_opening_verify_get_nonce('job_opening_remove_company_' . $co_id)) {
          deleteCompaniesByCompanyId($co_id);
          $html .= companyTable($user);
        } else {
          $html .= job_opening_forbidden();
        }
      } else {
        // 所有者でない企業情報の操作は一覧に落とさず拒否を伝える
        $html .= job_opening_forbidden();
      }
    }
  } else {
    $html .= notLogin();
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
  if (job_opening_current_user_can_manage()) {
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
    $html .= '<strong class="who-is-login">現在、' . esc_html($user->display_name) . "としてログインしています(" . $loginout . "する)</strong>";
    $html .= create_card($user);
  } else {
    $html .= notLogin();
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
  if (job_opening_current_user_can_manage()) {
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
    $html .= '<strong class="who-is-login">現在、' . esc_html($user->display_name) . "としてログインしています(" . $loginout . "する)</strong>";
    $html .= create_company($user);
  } else {
    $html .= notLogin();
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

    // date() は PHP の date.timezone を見るため、サイトの設定時刻で今日を求める
    $today = current_time('Y-m-d');
    $expires = job_opening_parse_date($job_expires, wp_timezone());
    // 解釈できない掲載終了日は、判定不能を期限切れに倒すと原因の分かりにくい非表示になるため
    // 掲載を続ける側に倒す。strtotime() の false との大小比較も同じ理由で使わない。
    if (!$expires || $today <= $expires->format('Y-m-d')) {
      $html .= userJobTable($post_id);
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
  if (job_opening_current_user_can_manage()) {
    echo job_openings_list();
  }
}

function company_list_admin()
{
  if (job_opening_current_user_can_manage()) {
    echo company_list();
  }
}

function job_openings_add_admin()
{
  if (job_opening_current_user_can_manage()) {
    echo job_openings_add();
  }
}

function company_add_admin()
{
  if (job_opening_current_user_can_manage()) {
    echo company_add();
  }
}
