<?php

/**
 * @package job_opening_plugin
 * @version 0.1
 */
/*
Plugin Name: Job Opening
Plugin URI: https://github.com/yui666a/job-openings-plugin
Description: 求人情報を簡易登録可能なプラグイン
Version: 0.1
Author: yui666a
Author URI: http://style-arts.jp/
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
define('JOB_OPENING_VERSION', '0.1');
define('JOB_OPENING__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('JOB_OPENING__MINIMUM_WP_VERSION', '5.9');
define('UPLOAD_DIR', wp_upload_dir());
define('HOME_URL', get_option("home"));

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
  // 郵便番号自動入力
  // see: https://github.com/yubinbango/yubinbango
  wp_enqueue_script('yubinBango', '//yubinbango.github.io/yubinbango/yubinbango.js', "", "0.1", false);

  // JS
  wp_enqueue_script('jo-main-script', plugin_dir_url(__FILE__) . 'js/main.js', array('jquery'), "0.1", true);
  wp_enqueue_script('jo-coAutoInput-script', plugin_dir_url(__FILE__) . 'js/companyAutoInput.js', array('jquery'), "0.1", true);
  wp_enqueue_script('jo-tinymce', plugin_dir_url(__FILE__) . 'js/tinymce/tinymce.min.js', array('jquery'), "0.1", true);
  wp_enqueue_script('jo-tinymce-jquery', plugin_dir_url(__FILE__) . 'js/tinymce/jquery.tinymce.min.js', array('jquery'), "0.1", true);
  wp_enqueue_script('jo-tinymce-custom', plugin_dir_url(__FILE__) . 'js/tinymce.js', array('jquery'), "0.1", true);

  // CSS
  wp_enqueue_style('jo-normalize', plugin_dir_url(__FILE__) . 'css/normalize.css', "", "0.1");
  wp_enqueue_style('jo-main', plugin_dir_url(__FILE__) . 'css/style.css', "", "0.1");
  // wp_enqueue_style('jo-user', plugin_dir_url(__FILE__) . 'css/userStyle.css', "", "0.1");
  wp_enqueue_style('jo-card', plugin_dir_url(__FILE__) . 'css/cardStyle.css', "", "0.1");
  wp_enqueue_style('jo-header', plugin_dir_url(__FILE__) . 'css/header.css', "", "0.1");
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
  create_table_meta();
  //作成したいディレクトリ（のパス）
  $directory_path = "/sac_jo/company_images";
  wp_mkdir_p(UPLOAD_DIR["basedir"] . $directory_path);

  // オプションを追加
  add_option('sac_job_openings_list', 'job_opening_list', '', 'yes');
  add_option('sac_company_list', 'company_list', '', 'yes');
  add_option('sac_job_openings_add', 'add_job_opening', '', 'yes');
  add_option('sac_company_add', 'add_company', '', 'yes');
  add_option('sac_user_job_openings', 'user_job_openings', '', 'yes');
  update_option("sac_job_openings_list", "job_opening_list");
  update_option("sac_company_list", "company_list");
  update_option("sac_job_openings_add", "add_job_opening");
  update_option("sac_company_add", "add_company");
  update_option("sac_user_job_openings", "user_job_openings");

  // 固定ページを作成
  wp_insert_post(array('post_title' => '作成した求人一覧', 'post_content'  => '[job_openings_list]',  'post_name' => "job_opening_list", 'post_type'      => 'page', 'post_status'   => 'publish', 'post_author'   => 1));
  wp_insert_post(array('post_title' => '作成した企業一覧', 'post_content'  => '[company_list]',       'post_name' => "company_list", 'post_type'      => 'page', 'post_status'   => 'publish', 'post_author'   => 1));
  wp_insert_post(array('post_title' => '求人情報を作成', 'post_content'  => '[job_openings_add]',     'post_name' => "add_job_opening", 'post_type'      => 'page', 'post_status'   => 'publish', 'post_author'   => 1));
  wp_insert_post(array('post_title' => '企業情報を作成', 'post_content'  => '[company_add]',          'post_name' => "add_company", 'post_type'      => 'page', 'post_status'   => 'publish', 'post_author'   => 1));
  wp_insert_post(array('post_title' => '求人一覧', 'post_content'  => '[user_job_openings]',         'post_name' => "job_openings_table", 'post_type'      => 'page', 'post_status'   => 'publish', 'post_author'   => 1));
}
register_activation_hook(__FILE__, 'on_activate');

/**
 * TODO: プラグインを無効にしたときの処理を書く
 */
function on_deactivation()
{
  global $wpdb;
  //➀テーブル名があったら
  if ($wpdb->get_var("show tables like '" . $wpdb->prefix . "sac_job_opening_companies" . "'") == $wpdb->prefix . "sac_job_opening_companies") { // 「==」へ変更
    //➁DROP TABLEを実行
    $sql = "DROP TABLE " . $wpdb->prefix . "sac_job_opening_companies";
    $wpdb->query( $sql );
  }
  //➀テーブル名があったら
  if ($wpdb->get_var("show tables like '" . $wpdb->prefix . "sac_job_opening_companies_meta" . "'") == $wpdb->prefix . "sac_job_opening_companies_meta") { // 「==」へ変更
    //➁DROP TABLEを実行
    $sql = "DROP TABLE " . $wpdb->prefix . "sac_job_opening_companies_meta";
    $wpdb->query( $sql );
  }
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
function get_custom_page_template($page_template)
{
  $page_template = JOB_OPENING__PLUGIN_DIR . 'view/template/single-job_openings.php';
  return $page_template;
}
// add_filter( 'page_template', 'get_custom_page_template' );
add_filter('single_template', 'get_custom_page_template');



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
    'rewrite'            => array('slug' => 'job_openings', 'with_front' => false),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 5, // この投稿タイプが表示されるメニューの位置
    'menu_icon'          => 'dashicons-edit', // メニューで使用するアイコン
    'supports'           => array(
      'title',
      'editor',
      'author',
      'thumbnail', // サムネイル
      'excerpt', // 抜粋
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
