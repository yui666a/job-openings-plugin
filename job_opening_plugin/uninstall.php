<?php

/**
 * プラグインを削除（アンインストール）したときの処理
 *
 * 企業情報は独自テーブルに保存しているため、WordPress 側では消えない。
 * 無効化ではなく削除の時点で消す。
 *
 * @package job_opening_plugin
 */

// WordPress の削除処理以外から直接実行された場合は何もしない
if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

global $wpdb;

// テーブル名はプレースホルダに渡せないため、識別子として直接埋め込む
foreach (array('sac_job_opening_companies', 'sac_job_opening_companies_meta') as $suffix) {
  $table_name = $wpdb->prefix . $suffix;
  $wpdb->query("DROP TABLE IF EXISTS `{$table_name}`");
}
