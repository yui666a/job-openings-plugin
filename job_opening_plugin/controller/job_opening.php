<?php

function getPublishedCard()
{
  $args = array(
    'post_type' => array('job_openings'),
    // 'category_name' => 'カテゴリのスラッグ',	// 絞り込むカテゴリ
    // 'tag' => 'タグスラッグ',	// 絞り込むタグ
    // 's' => '検索文字列',	// 検索文字列
    // 'posts_per_page' => 3,	// 表示件数
    'offset' => 0,
    'post_status' => 'publish',
    'orderby' => 'post_date',  //新着順
    'order' => 'DESC',  // 降順 昇順(ASC)
    'numberposts' => -1, //全件取得
  );

  return get_posts($args);
}