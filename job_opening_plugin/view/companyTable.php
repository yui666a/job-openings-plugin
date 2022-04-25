<?php

function companyTable($user)
{
  $html = "";
  $loginout = wp_loginout($_SERVER['REQUEST_URI'], false);
  $html .= '<strong class="who-is-login">現在、' . $user->display_name . "としてログインしています(" . $loginout . "する)</strong>";

  $companies = getCompaniesByUserId($user->ID);

  // 表 ヘッダーの表示
  $html .=  make_company_table_head();

  $html .=  '<tbody id="the-list">';
  // ob_start();
  foreach ($companies as $data) :
    $html .=  make_company_table_row($data);
  endforeach;
  $html .=  '</tbody>';

  // 表 フッターの表示
  $html .= '</table>';
  // ob_get_clean();
  return $html;
}
