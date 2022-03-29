<?php

/**
 * 求人情報の特徴のタグを表示する
 *
 * TODO: タグクリックのリンクを作成
 */
function addTags($recruitment_type, $remote_work){
  $tags = "";
  if($recruitment_type == "new_graduate"){
    $tags .= "<li>新卒</li>";
  }else if($recruitment_type == "mid_career"){
    $tags .= "<li>中途</li>";
  }else {
    $tags .= "<li>新卒</li><li>中途</li>";
  }

  if($remote_work == "true"){
    $tags .= "<li>リモートワーク可</li>";
  }

  return $tags;
}