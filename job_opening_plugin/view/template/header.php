<?php

function header_link_buttons()
{
  $html = '';
  $sac_company_list = HOME_URL."/".get_option("sac_company_list");
  $sac_job_openings_list = HOME_URL."/".get_option("sac_job_openings_list");
  $sac_job_openings_add = HOME_URL."/".get_option("sac_job_openings_add");
  $sac_company_add = HOME_URL."/".get_option("sac_company_add");

  $html = <<<EOF
  <div class="step-wrapper">
    <!-- <div class="step-number" id="step1-index">1</div> -->
    <div class="step-text" id="step1-label">
      <a href="{$sac_company_add}">企業情報を新規追加</a>
    </div>

    <!-- <div class="step-number" id="step2-index">2</div> -->
    <div class="step-text" id="step2-label">
      <a href="{$sac_company_list}">作成した企業一覧</a>
    </div>

    <!-- <div class="step-number" id="step3-index">3</div> -->
    <div class="step-text" id="step3-label">
      <a href="{$sac_job_openings_add}">求人情報を新規追加</a>
    </div>

    <!-- <div class="step-number" id="step4-index">4</div> -->
    <div class="step-text" id="step4-label">
      <a href="{$sac_job_openings_list}">作成した求人一覧</a>
    </div>
  </div>
EOF;
  return $html;
}
