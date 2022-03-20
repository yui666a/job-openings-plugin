<?php

function create_job_openingssss(
  $company_id,
  $recruitment_type,
  $title,
  $url,
  $position,
  $work_detail,
  $application_conditions,
  $working_conditions,
  $location,
  $remote_work,
  $occupation,
  $date_period_type,
  $trip_period,
  $trip_start,
  $trip_last,
  $zipcode,
  $address,
  $address_2,
  $company_salary,
  $apply_link
) {

  $tags = addTags($recruitment_type, $remote_work);
  $can_remote_work = $remote_work == "true" ? "(リモートワーク可)" : "";
  $company = getCompanyById($company_id)[0];

  $reg_str = "/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/";
  if (preg_match($reg_str, $apply_link)) {
    $content  = $company->co_name . "<br />NAGAOKA WORKER募集担当　様<br /><br />";
    $content .= 'NAGAOKA WORKERホームページ掲載の貴社求人を拝見し、応募させていただきたくご連絡を差し上げました。<br /><br />';
    $content .= '求人No: <br />';
    $content .= '募集職種・役職: <br /><br />';
    $content .= '応募書類を添付申し上げます。<br />ぜひ一度、面接の機会をいただきたく、ご検討のほどどうぞよろしくお願い申し上げます。<br />※このメールに履歴書、職務経歴書二点の添付をお願いいたします。';

    $search = array('<br />', '@', '\n', '&');
    $replace = array('%0D%0A', '□', '%0D%0A', '&amp;');
    $main_text = str_replace($search, $replace, $content);
    $converted_address = str_replace($search, $replace, $apply_link);
    $qwer = "mailto:" . $converted_address . '?subject=' . $title . '&body=' . $main_text . '%0D%0A（メールアドレス中の□を@に変更してください）"';
    //  target="_blank" rel="noopener noreferrer';
  }else{
    $qwer = $apply_link;
  }

  // 職種
  $occupation_text = "";
  switch ($occupation) {
    case "sales_associate":
      $occupation_text = "営業";
      break;
    case "clerk":
      $occupation_text = "事務・管理";
      break;
    case "marketer":
      $occupation_text = "企画・マーケティング・経営・管理職";
      break;
    case "service":
      $occupation_text = "サービス・販売・外食";
      break;
    case "web":
      $occupation_text = "Web・インターネット・ゲーム";
      break;
    case "creative":
      $occupation_text = "クリエイティブ（メディア・アパレル・デザイン）";
      break;
    case "expert":
      $occupation_text = "専門職（コンサルタント・士業・金融・不動産）";
      break;
    case "it_engineer":
      $occupation_text = "ITエンジニア（システム開発・SE・インフラ）";
      break;
    case "engineer":
      $occupation_text = "エンジニア（機械・電気・電子・半導体・制御）";
      break;
    case "chemical_engineer":
      $occupation_text = "素材・化学・食品・医薬品技術職";
      break;
    case "civil_engineer":
      $occupation_text = "建築・土木技術職";
      break;
    case "transporter":
      $occupation_text = "技能工・設備・交通・運輸";
      break;
    case "medical_welfare":
      $occupation_text = "医療・福祉・介護";
      break;
    case "public_servant":
      $occupation_text = "教育・保育・公務員・農林水産・その他";
      break;
  }



  $aaa = HOME_URL . "/" . get_option("sac_job_openings_list");

  $html = <<<EOF
  <div class="job-opening-card">
    <div class="header-wrapper">
      <div class="container-header">
        <h3 class="job-list-text-link">{$title}</h3>
        <div class="job-list-tag-box">
          <ul class="job-list-tag">
            <span>{$tags}</span>
          </ul>
        </div>
      </div>
    </div>

    <div class="main-box">
      <div class="job-list-img-wrapper">
        <img
        src="{$company->co_logo}"
        alt="{$company->co_name}のロゴ"
        width="100%"
        height="100%"
        />
      </div>
      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">仕事内容</h1>
        </div>
        <div class="work-detail-text-box">
          <pre class="work-detail-text">{$work_detail}</pre>
        </div>
        <div style="border-collapse: collapse" border-color="EEE">
          <div class="assignment">
            <div class="assignment-item-label">職種 / 募集ポジション</div>
            <div class="assignment-item-value">
              <pre>{$occupation_text}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">雇用形態</div>
            <div class="assignment-item-value">
              <pre>{$working_conditions}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">給与</div>
            <div class="assignment-item-value">
              <pre>{$company_salary}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">勤務地</div>
            <div class="assignment-item-value">
              <a href="https://maps.google.com/maps?q={$address}{$address_2}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false" class="google-map-address"
              >〒{$zipcode}  {$address} {$address_2}</a> {$can_remote_work}</div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">就業時間</div>
            <div class="assignment-item-value">
              <pre>{$company->co_office_hours}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">休日</div>
            <div class="assignment-item-value">
              <pre>{$company->co_day_off}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">制度・福利厚生</div>
            <div class="assignment-item-value">
              <pre>{$company->co_employee_benefits}</pre>
            </div>
          </div>
        </div>
      </div>

      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">募集要項</h1>
        </div>
        <div class="work-detail-text-box">
          <pre class="work-detail-text">{$application_conditions}</pre>
        </div>
      </div>

      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">会社概要</h1>
        </div>
        <div class="work-detail-text-box">
          <pre class="work-detail-text">{$company->co_pr_point}</pre>
        </div>

        <div class="assignment-table-box">
          <div class="company-information-table-box">
            <div style="border-collapse: collapse" border-color="EEE">
              <div class="assignment">
                <div class="assignment-item-label">会社名</div>
                <div class="assignment-item-value">
                  <pre>{$company->co_name}</pre>
                </div>
              </div>

              <!--
              <div class="assignment">
                <div class="assignment-item-label">グループについて</div>
                <div class="assignment-item-value">
                  <pre>(TODO: グループについての情報を表示)</pre>
                </div>
              </div>

              <div class="assignment">
                <div class="assignment-item-label">事業会社一覧</div>
                <div class="assignment-item-value">
                  <pre>(TODO: 事業会社一覧の情報を表示)</pre>
                </div>
              </div>
              -->

              <div class="assignment">
                <div class="assignment-item-label">本社所在地</div>
                <div class="assignment-item-value">
                  <a href="https://maps.google.com/maps?q={$company->co_address}{$company->co_address2}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false" class="google-map-address"
                  >〒{$company->co_zip_code} {$company->co_address} {$company->co_address2}</a
                >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      
      <div class="btn-application-under">
        <a href="{$qwer}" class="btn-application-under-text">応募画面に進む</a>
      </div>
    </div>
  </div>
EOF;
  return $html;
}
