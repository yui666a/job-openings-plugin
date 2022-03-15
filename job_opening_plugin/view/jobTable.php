<?php

function aaa($user)
{
  $html = "";
  $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
  $html .= "<strong>現在、" . $user->display_name . "としてログインしています(".$loginout."する)</strong>";

  $args = array(
    'post_type' => 'post',  // 投稿タイプ
    // 'category_name' => 'カテゴリのスラッグ',	// 絞り込むカテゴリ
    // 'tag' => 'タグスラッグ',	// 絞り込むタグ
    // 's' => '検索文字列',	// 検索文字列
    // 'posts_per_page' => 3,	// 表示件数
    'offset' => 0,
    'post_status' => 'publish, inherit, pending, private, future, draft',  // 全て取得
    // 'post_status' => 'publish, inherit, pending, private, future, draft, trash',  // 全て取得
    // 'post_type' => array('job_opening', 'job_listing','job_openings'),
    'post_type' => array('job_openings'),
    'orderby'=>'post_date',  //新着順
    'order' => 'DESC',  // 降順 昇順(ASC)
    'numberposts' => -1, //全件取得
    'author'=>$user->ID
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
    $permalink = get_permalink($post_id);
    $job_expires = get_post_meta($post_id, '_expired_date', true);
    $job_location = get_post_meta($post_id, '_job_location', true);

    $status_icon = "";
    /**
     * To check kinds of status,
     * see: https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_post_status
     */
    switch (get_post_status($post_id)) {
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
  return $html;
}
