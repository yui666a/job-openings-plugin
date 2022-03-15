<?php

function create_job_openingssss(
  $company_id,
  $recruitment_type ,
  $title ,
  $url ,
  $position ,
  $work_detail ,
  $application_conditions ,
  $working_conditions ,
  $location ,
  $remote_work ,
  $occupation ,
  $date_period_type ,
  $trip_period ,
  $trip_start ,
  $trip_last)
{
  $company = getCompanyById($company_id)[0];


  $html = <<<EOF
<div class="contents-card-wrapper">
  <div class="job-list-img-wrapper">
    <img
      src="{$company->co_logo}"
      alt="{$company->co_name}のロゴ"
      width="100%"
      height="100%"
    />
  </div>
  <div>
    <div class="main-box">
      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">仕事内容</h1>
        </div>
        <div class="work-detail-text-box">
          <pre class="work-detail-text">
            {$work_detail}
                      </pre
          >
        </div>
      </div>

      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">募集要件</h1>
        </div>
        <div class="work-detail-text-box">
          <pre class="work-detail-text">
            {$application_conditions}
                      </pre
          >
        </div>
      </div>

      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">配属会社</h1>
        </div>
        <div class="work-detail-text-box">
          <pre class="work-detail-text">
            {$company->co_pr_point}
          </pre>
        </div>
      </div>

      <div class="assignment-table-box">
        <table style="border-collapse: collapse" border-color="EEE">
          <tr>
            <th class="assignment-table-items">職種 / 募集ポジション</th>
            <td class="assignment-table-contents">
              <pre>{$occupation}</pre>
            </td>
          </tr>
          <tr>
            <th class="assignment-table-items">雇用形態</th>
            <td class="assignment-table-contents">
              <pre>{$working_conditions}</pre>
            </td>
          </tr>
          <tr>
            <th class="assignment-table-items">給与</th>
            <td class="assignment-table-contents">
              <pre>(TODO: 給与の情報を表示)</pre>
            </td>
          </tr>
          <tr>
            <th class="assignment-table-items">勤務地</th>
            <td class="assignment-table-contents">
              <pre>(TODO: 勤務地の情報を表示)</pre>
            </td>
          </tr>
          <tr>
            <th class="assignment-table-items">就業時間</th>
            <td class="assignment-table-contents">
              <pre>{$company->co_office_hours}</pre>
            </td>
          </tr>
          <tr>
            <th class="assignment-table-items">休日</th>
            <td class="assignment-table-contents">
              <pre>{$company->co_day_off}</pre>
            </td>
          </tr>
          <tr>
            <th class="assignment-table-items">制度・福利厚生</th>
            <td class="assignment-table-contents">
              <pre>{$company->co_employee_benefits}</pre>
            </td>
          </tr>
        </table>
        <div class="company-information-table-box">
          <table style="border-collapse: collapse" border-color="EEE">
            <tr>
              <th class="assignment-table-items" colspan="2">
                <pre>会社情報</pre>
              </th>
            </tr>
            <tr>
              <th class="assignment-table-items">会社名</th>
              <td class="assignment-table-contents">
                <pre>{$company->co_name}</pre>
              </td>
            </tr>
            <!--<tr>
              <th class="assignment-table-items">グループについて</th>
              <td class="assignment-table-contents">
                <pre>(TODO: グループについての情報を表示)</pre>
              </td>
            </tr>-->
            <!--<tr>
              <th class="assignment-table-items">事業会社一覧</th>
              <td class="assignment-table-contents">
                <pre>(TODO: 事業会社一覧の情報を表示)</pre>
              </td>
            </tr>-->
            <tr>
              <th class="assignment-table-items">本社所在地</th>
              <td class="assignment-table-contents">
                <pre><a href="https://maps.google.com/maps?q={$company->co_address}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false" class="google-map-address"
                >〒{$company->co_zip_code}  {$company->co_address}</a
              ></pre>
              </td>
            </tr>
            <tr>
              <th class="assignment-table-items">勤務地の所在地</th>
              <td class="assignment-table-contents">
                <pre><a href="https://maps.google.com/maps?q={$company->co_address}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false" class="google-map-address"
                >〒{$company->co_zip_code}  {$company->co_address}
              </a></pre>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="btn-application-under">
      <a href="#" class="btn-application-under-text">応募メールを送る</a>
    </div>
  </div>
</div>
EOF;
  return $html;
}
