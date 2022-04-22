<?php

include_once(JOB_OPENING__PLUGIN_DIR . 'util/dictionaries.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/userJobOpening.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/jobTable.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/companyTable.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/addCard.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/editCard.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/editCompany.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/addCompany.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/header.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/card.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/template/addTags.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'controller/editJob.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'controller/editCompany.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'controller/create_company.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'controller/create_card.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'controller/company.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'controller/job_opening.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/jobTable.php');
include_once(JOB_OPENING__PLUGIN_DIR . 'view/companyTable.php');



//=========================
// 管理画面にメニューを登録
//=========================
add_action('admin_menu', function () {

  //---------------------------------
  // メインメニュー
  //---------------------------------
  add_menu_page(
    '求人簡易投稿', // ページのタイトルタグ<title>に表示されるテキスト
    '求人簡易投稿',   // 左メニューとして表示されるテキスト
    'manage_options',       // 必要な権限 manage_options は通常 administrator のみに与えられた権限
    'job_openings',        // 左メニューのスラッグ名 →URLのパラメータに使われる
    '', // メニューページを表示する際に実行される関数
    'dashicons-media-document',       // メニューのアイコンを指定 https://developer.wordpress.org/resource/dashicons/#awards
    99                             // メニューが表示される位置のインデックス(0が先頭)
  );

  //---------------------------------
  // サブメニュー
  //---------------------------------
  add_submenu_page(
    'job_openings',    // 親メニューのスラッグ
    '求人一覧', // ページのタイトルタグ<title>に表示されるテキスト
    '求人一覧', // サブメニューとして表示されるテキスト
    'manage_options', // 必要な権限 manage_options は通常 administrator のみに与えられた権限
    'job_openings',  // サブメニューのスラッグ名。この名前を親メニューのスラッグと同じにすると親メニューを押したときにこのサブメニューを表示します。一般的にはこの形式を採用していることが多い。
    'job_openings_list_admin', //（任意）このページのコンテンツを出力するために呼び出される関数
    10
  );

  add_submenu_page(
    'job_openings',
    '企業一覧',
    '企業一覧',
    'manage_options',
    'job_openings-companies',
    'company_list_admin',
    20
  );

  add_submenu_page(
    'job_openings',
    '求人 新規作成',
    '求人 新規作成',
    'manage_options',
    'job_openings-add-card',
    'job_openings_add_admin',
    30
  );

  add_submenu_page(
    'job_openings',
    '企業 新規作成',
    '企業 新規作成',
    'manage_options',
    'job_openings-add-company',
    'company_add_admin',
    40
  );

  add_submenu_page(
    'job_openings',
    '設定',
    '設定',
    'manage_options',
    'job_openings-settings',
    'settings', // TODO: not implemented
    50
  );

});