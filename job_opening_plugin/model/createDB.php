<?php

function create_table()
{
  global $wpdb;

  $sql = "";
  $charset_collate = "";

  // 接頭辞の追加（socal_count_cache）
  $table_name = $wpdb->prefix . 'sac_job_opening_companies';

  // charsetを指定
  if (!empty($wpdb->charset))
    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} ";

  // 照合順序を指定
  if (!empty($wpdb->collate))
    $charset_collate .= "COLLATE {$wpdb->collate}";

  // 企業情報のDB作成クエリ
  $sql = "
    CREATE TABLE IF NOT EXISTS {$table_name} (
      co_id bigint UNSIGNED NOT NULL AUTO_INCREMENT,
      co_name VARCHAR(50) NOT NULL,
      user_id bigint UNSIGNED NOT NULL,
      status VARCHAR(20) NOT NULL,
      co_url TEXT,
      co_pr_point LONGTEXT,
      co_zip_code VARCHAR(8),
      co_address VARCHAR(100),
      co_sector VARCHAR(100),
      co_achievement LONGTEXT,
      co_office_hours LONGTEXT,
      co_employee_benefits LONGTEXT,
      co_day_off LONGTEXT,
      created_at TIMESTAMP DEFAULT 0,
      updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (co_id)
    ) {$charset_collate};";

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}



function create_table_meta()
{
  global $wpdb;

  $sql = "";
  $charset_collate = "";

  // 接頭辞の追加（socal_count_cache）
  $table_name = $wpdb->prefix . 'sac_job_opening_companies_meta';

  // charsetを指定
  if (!empty($wpdb->charset))
    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} ";

  // 照合順序を指定
  if (!empty($wpdb->collate))
    $charset_collate .= "COLLATE {$wpdb->collate}";

  // 企業情報のDB作成クエリ
  $sql = "
    CREATE TABLE IF NOT EXISTS {$table_name} (
      id bigint UNSIGNED NOT NULL AUTO_INCREMENT,
      co_id bigint NOT NULL,
      meta_type VARCHAR(20) NOT NULL,
      meta_value VARCHAR(100) NOT NULL,
      created_at TIMESTAMP DEFAULT 0,
      updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
    ) {$charset_collate};";

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}

