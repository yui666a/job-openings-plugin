<?php

function getCompanies()
{
  global $wpdb;
  $query = "SELECT * FROM `" . $wpdb->prefix . "sac_job_opening_companies`;";
  $companies = $wpdb->get_results($query, OBJECT);
  return $companies;
}

function getCompaniesByUserId($userId)
{
  global $wpdb;
  $query = $wpdb->prepare(
    "SELECT * FROM `{$wpdb->prefix}sac_job_opening_companies` WHERE user_id = %d",
    $userId
  );
  $companies = $wpdb->get_results($query, OBJECT);
  return $companies;
}

function getCompanyById($companyId)
{
  global $wpdb;
  $query = $wpdb->prepare(
    "SELECT * FROM `{$wpdb->prefix}sac_job_opening_companies` WHERE co_id = %d",
    $companyId
  );
  $companies = $wpdb->get_results($query, OBJECT);
  // 該当なしのとき $companies[0] は未定義オフセットの警告を出すため、null に丸める
  return $companies[0] ?? null;
}

function deleteCompaniesByCompanyId($companyId)
{
  global $wpdb;
  $query = $wpdb->prepare(
    "DELETE FROM `{$wpdb->prefix}sac_job_opening_companies` WHERE co_id = %d",
    $companyId
  );
  $wpdb->query($query);
}
