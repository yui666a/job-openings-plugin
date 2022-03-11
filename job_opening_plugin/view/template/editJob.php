<?php

function editJob($user, $job_id)
{
  // ワンタイムチケットの生成とセッションへの保存
  $session_key = md5(sha1(uniqid(mt_rand(), true)));
  $_SESSION['key'] = $session_key;

  global $wpdb;
  $query = "SELECT * FROM `" . $wpdb->prefix . "sac_job_opening_companies` WHERE user_id=" . $user->ID . ";";
  $companies = $wpdb->get_results($query, OBJECT);

  //htmlの出力
  $action_url = str_replace('%7E', '~', $_SERVER['REQUEST_URI']);

  $html = edit_job_opening($user, $action_url, $session_key, $companies, $job_id);
  return $html;
}
