<?php

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
    'job-openings',        // 左メニューのスラッグ名 →URLのパラメータに使われる
    '', // メニューページを表示する際に実行される関数
    'dashicons-media-document',       // メニューのアイコンを指定 https://developer.wordpress.org/resource/dashicons/#awards
    99                             // メニューが表示される位置のインデックス(0が先頭)
  );

  //---------------------------------
  // サブメニュー
  //---------------------------------
  add_submenu_page(
    'job-openings',    // 親メニューのスラッグ
    '求人一覧', // ページのタイトルタグ<title>に表示されるテキスト
    '求人一覧', // サブメニューとして表示されるテキスト
    'manage_options', // 必要な権限 manage_options は通常 administrator のみに与えられた権限
    'job-openings',  // サブメニューのスラッグ名。この名前を親メニューのスラッグと同じにすると親メニューを押したときにこのサブメニューを表示します。一般的にはこの形式を採用していることが多い。
    'job_openings_list', //（任意）このページのコンテンツを出力するために呼び出される関数
    10
  );

  add_submenu_page(
    'job-openings',
    '企業一覧',
    '企業一覧',
    'manage_options',
    'job-openings-companies',
    'company_list',
    20
  );

  add_submenu_page(
    'job-openings',
    '求人 新規作成',
    '求人 新規作成',
    'manage_options',
    'job-openings-add-card',
    'job_openings_add',
    30
  );

  add_submenu_page(
    'job-openings',
    '企業 新規作成',
    '企業 新規作成',
    'manage_options',
    'job-openings-add-company',
    'company_add',
    40
  );

  add_submenu_page(
    'job-openings',
    '設定',
    '設定',
    'manage_options',
    'job-openings-add-card',
    'job_openings_add', // TODO: edit here.
    40
  );

});