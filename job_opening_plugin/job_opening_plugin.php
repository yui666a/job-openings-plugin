<?php

/**
 * @package job_opening_plugin
 * @version 0.1
 */
/*
Plugin Name: Job Opening
Plugin URI: https://github.com/yui666a/job-openings-plugin
Description: TODO　求人情報を簡易登録可能なプラグイン
Version: 0.1
Author: yui666a
Author URI: https://yui666a.github.io/home/
*/

function console_log($data)
{
  echo '<script>';
  echo 'console.log(' . json_encode($data) . ')';
  echo '</script>';
}

function console_error($data)
{
  echo '<script>';
  echo 'console.error(' . json_encode($data) . ')';
  echo '</script>';
}

// 定数定義
// TODO: JOB_OPENING__MINIMUM_WP_VERSIONを定義
define('JOB_OPENING_VERSION', '0.1');
define('JOB_OPENING__PLUGIN_DIR', plugin_dir_path(__FILE__));
// define( 'JOB_OPENING__MINIMUM_WP_VERSION', '5.0' );
// define( 'JOB_OPENING_DELETE_LIMIT', 10000 );

// セッションの開始
session_start();

/** 
 * JS・CSSファイルを読み込む
 */
function add_files()
{
  // WordPress提供のjquery.jsを読み込まない
  wp_deregister_script('jquery');
  // jQueryの読み込み
  wp_enqueue_script('jquery', '//code.jquery.com/jquery-3.5.1.min.js', "", "0.1", false);

  // start select2ライブラリ読み込み
  wp_enqueue_style('select2css', '//cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css', "", "0.1");
  wp_enqueue_script('select2js', '//cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js', "", "0.1", false);
  // end select2ライブラリ読み込み

  // JS
  wp_enqueue_script('jo-main-script', plugin_dir_url(__FILE__) . 'js/main.js', array('jquery'), "0.1", true);
  // CSS
  wp_enqueue_style('jo-normalize', plugin_dir_url(__FILE__) . 'css/normalize.css', "", "0.1");
  wp_enqueue_style('jo-main', plugin_dir_url(__FILE__) . 'css/style.css', "", "0.1");
}
/**
 * wp_enqueue_scripts – フロントエンドをイベントトリガーにする
 * login_enqueue_scripts – ログイン画面をイベントトリガーにする
 * admin_enqueue_scripts – 管理画面をイベントトリガーにする
 */
add_action('wp_enqueue_scripts', 'add_files');
add_action('login_enqueue_scripts', 'add_files');
add_action('admin_enqueue_scripts', 'add_files');

require_once(JOB_OPENING__PLUGIN_DIR . 'routing.php');
require_once(JOB_OPENING__PLUGIN_DIR . 'view/view.php');

/**
 * プラグインを有効にしたときの処理
 */
function on_activate() {
  include_once(JOB_OPENING__PLUGIN_DIR . 'model/createDB.php');
  create_table();
}
register_activation_hook(__FILE__, 'on_activate');

/**
 * TODO: プラグインを無効にしたときの処理を書く
 */
function on_deactivation() {
}
register_deactivation_hook(__FILE__, 'on_deactivation');