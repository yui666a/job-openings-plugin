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

// 定数定義
define( 'JOB_OPENING_VERSION', '0.1' );
define( 'JOB_OPENING__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
// define( 'JOB_OPENING__MINIMUM_WP_VERSION', '5.0' );
// define( 'JOB_OPENING_DELETE_LIMIT', 10000 );

require_once( JOB_OPENING__PLUGIN_DIR . 'routing.php' );
require_once( JOB_OPENING__PLUGIN_DIR . 'view/view.php' );
