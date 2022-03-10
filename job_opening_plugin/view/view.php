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
    $html .= "<strong>" . $user->display_name . "としてログインしています</strong>";
    $args = array(
      'post_type' => 'post',  // 投稿タイプ
      // 'category_name' => 'カテゴリのスラッグ',	// 絞り込むカテゴリ
      // 'tag' => 'タグスラッグ',	// 絞り込むタグ
      // 's' => '検索文字列',	// 検索文字列
      // 'posts_per_page' => 3,	// 表示件数
      'offset' => 0,
      'post_status' => 'publish, inherit, pending, private, future, draft, trash',  // 全て取得
      // 'post_type' => array('job_opening', 'job_listing','job_openings'),
      'post_type' => array('job_openings'),
      'orderby' => 'date',  //新着順
      'order' => 'DESC',  // 降順 昇順(ASC)
      'numberposts' => -1, //全件取得
    );

    $posts = get_posts($args);
    // query_posts($args);
    // $posts_array = get_posts($args);
    $html .= make_job_openings_table_head();
    $html .=  '<tbody id="the-list">';
    // ループ
    global $post;
    foreach ($posts as $post) :
      setup_postdata($post);
      $post_id = get_the_ID();
      $title = get_the_title();
      $author = get_the_author();
      $post_date = get_the_date();
      $permalink = get_permalink( $post_id );
      $job_expires = get_post_meta($post_id, '_job_expires', true);
      $job_location = get_post_meta($post_id, '_job_location', true);

      $status_icon = "";
      /**
       * To check kinds of status,
       * see: https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_post_status
       * TODO: if you have to separate more kinds, use switch statement.
       */
      switch (get_post_status($post_id)){
        case 'publish':
          $status_icon = '<span data-tip="公開中" class="tips status-publish">公開中</span>';
          break;
        case 'auto-draft':
          $status_icon = '<span data-tip="自動下書き" class="tips status-auto-draft">自動下書き</span>';
          break;
        case 'future':
          $status_icon = '<span data-tip="予約投稿" class="tips status-future">予約投稿</span>';
          break;
        case 'trash':
          $status_icon = '<span data-tip="ゴミ箱" class="tips status-trash">ゴミ箱</span>';
          break;
        default:
          $status_icon = '<span data-tip="非公開" class="tips status-draft">非公開</span>';
          break;
      }
      $html .=  make_job_openings_table_row($post_id, $title, $author, $post_date, $job_expires, $job_location, $status_icon, $permalink);
    endforeach;
    $html .=  '</tbody>';

    wp_reset_postdata(); // 投稿データのリセット
    // 表 フッターの表示
    $html .=  make_job_openings_table_head();
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
  $user = wp_get_current_user();
  $html = "";
  $html .= create_company($user);

  return $html;
}