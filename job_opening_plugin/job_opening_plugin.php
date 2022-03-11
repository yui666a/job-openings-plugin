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
  echo '<script>console.log(' . json_encode($data) . ')</script>';
}

function console_error($data)
{
  echo '<script>console.error(' . json_encode($data) . ')</script>';
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
  wp_enqueue_script('jo-coAutoInput-script', plugin_dir_url(__FILE__) . 'js/companyAutoInput.js', array('jquery'), "0.1", true);
  // CSS
  wp_enqueue_style('jo-normalize', plugin_dir_url(__FILE__) . 'css/normalize.css', "", "0.1");
  wp_enqueue_style('jo-main', plugin_dir_url(__FILE__) . 'css/style.css', "", "0.1");
  wp_enqueue_style('jo-user', plugin_dir_url(__FILE__) . 'css/userStyle.css', "", "0.1");
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
function on_activate()
{
  include_once(JOB_OPENING__PLUGIN_DIR . 'model/createDB.php');
  create_table();
}
register_activation_hook(__FILE__, 'on_activate');

/**
 * TODO: プラグインを無効にしたときの処理を書く
 */
function on_deactivation()
{
}
register_deactivation_hook(__FILE__, 'on_deactivation');


/**
 * ショートコードの登録
 */
add_shortcode('job_openings_list', 'job_openings_list');
add_shortcode('job_openings_add', 'job_openings_add');
add_shortcode('company_list', 'company_list');
add_shortcode('company_add', 'company_add');
add_shortcode('user_job_openings', 'user_job_openings');


/**
 * テンプレートの指定
 */
function get_custom_page_template( $page_template ) {
  $page_template = JOB_OPENING__PLUGIN_DIR . 'view/template/single-job_openings.php';
  return $page_template;
}
// add_filter( 'page_template', 'get_custom_page_template' );
add_filter( 'single_template', 'get_custom_page_template' );



function add_custom_post_type()
{
  $labels = array(
    'name'               => '求人情報',
    'singular_name'      => '求人情報',
    'add_new'            => '新規求人',
    'add_new_item'       => '新規求人の追加',
    'edit_item'          => '求人情報の編集',
    'new_item'           => '求人一覧',
    'all_items'          => '求人一覧',
    'view_item'          => '求人情報を見る',
    'search_items'       => '求人情報を検索する',
    'not_found'          => '求人情報はありません',
    'not_found_in_trash' => 'ゴミ箱に求人情報はありません',
    'parent_item_colon'  => '',
    'menu_name'          => '求人情報'
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true, // 利用する場合はtrueにする
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug' => 'book'),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 5, // この投稿タイプが表示されるメニューの位置
    'menu_icon'          => 'dashicons-edit', // メニューで使用するアイコン
    'supports'           => array(
      'title',
      'editor',
      'author',
      // 'thumbnail', // サムネイル
      // 'excerpt', // 抜粋
      // 'comments', // コメント
      'custom-fields',
      'custom_feature' => [
        'setting-1' => 'value',
        'setting-2' => 'value',
      ],
    )
  );

  register_post_type(
    'job_openings', // 1.投稿タイプ名 
    $args
  );
}
add_action('init', 'add_custom_post_type');

// カスタムタクソノミーの追加
function add_custom_taxonomy()
{
  // カテゴリー
  register_taxonomy(
    'job_openings-category', // 1.タクソノミーの名前
    'job_openings',          // 2.利用する投稿タイプ
    array(            // 3.オプション
      'label' => 'カテゴリー', // タクソノミーの表示名
      'hierarchical' => true, // 階層を持たせるかどうか
      'public' => true, // 利用する場合はtrueにする
    )
  );
  // タグ
  register_taxonomy(
    'job_openings-tag', // 1.タクソノミーの名前
    'job_openings',     // 2.利用する投稿タイプ
    array(       // 3.オプション
      'label' => 'タグ', // タクソノミーの表示名
      'hierarchical' => false, // 階層を持たせるかどうか
      'public' => true, // 利用する場合はtrueにする
    )
  );
}
add_action('init', 'add_custom_taxonomy');
