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
  $query = "SELECT * FROM `" . $wpdb->prefix . "sac_job_opening_companies` WHERE user_id=" . $userId . ";";
  $companies = $wpdb->get_results($query, OBJECT);
  return $companies;
}

function getCompanyById($companyId)
{
  global $wpdb;
  $query = "SELECT * FROM `" . $wpdb->prefix . "sac_job_opening_companies`WHERE co_id=" . $companyId . ";";
  $companies = $wpdb->get_results($query, OBJECT);
  return $companies;
}

function deleteCompaniesByCompanyId($companyId)
{
  global $wpdb;
  $query = "DELETE FROM `" . $wpdb->prefix . "sac_job_opening_companies` WHERE " . $wpdb->prefix . "sac_job_opening_companies.co_id = " . $companyId . ";";
  $wpdb->get_results($query, OBJECT);
}
