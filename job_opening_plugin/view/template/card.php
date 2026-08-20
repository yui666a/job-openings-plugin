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
  $apply_link
) {

  $tags = addTags($recruitment_type, $remote_work);
  $can_remote_work = $remote_work == "true" ? "(リモートワーク可)" : "";
  $company = getCompanyById($company_id);

  $qwert = "";
  foreach ($occupation as $data) {
    $qwert .= get_occupation_ja($data) . "、";
  }
  $qwert = mb_substr($qwert, 0, -1, 'UTF-8');

  $reg_str = "/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/";
  if (preg_match($reg_str, $apply_link)) {
    global $wp;
    $content  = $company->co_name . "<br />NAGAOKA WORKER募集担当　様<br /><br />";
    $content .= 'NAGAOKA WORKERホームページ掲載の貴社求人を拝見し、応募させていただきたくご連絡を差し上げました。<br /><br />';
    $content .= '求人タイトル: ' . $title . '<br />';
    $content .= '募集職種・役職: ' . $qwert . ' ' . $position . '<br /><br />';
    // $content .= '該当URL: ' . home_url( $wp->request ) . '<br /><br />';
    $content .= '応募書類を添付申し上げます。<br />ぜひ一度、面接の機会をいただきたく、ご検討のほどどうぞよろしくお願い申し上げます。<br />※このメールに履歴書、職務経歴書二点の添付をお願いいたします。';

    // $search = array('<br />', '@', '\n');
    // $replacements = array('%0D%0A', '□', '%0D%0A',);
    // $main_text = str_replace($search, $replace, $content);
    $search = array('%0D%0A', '□', '%0D%0A', '%26');
    $replacements = array('<br />', '@', '\n', "&");
    $main_text =  str_replace($replacements, $search, $content);
    $converted_address = str_replace($search, $replacements, $apply_link);
    $qwer = 'mailto:' . $converted_address . '?subject=' . $title . '&body=' . $main_text . '%0D%0A%0D%0A（メールアドレス中の□を@に変更してください）';
    //  target="_blank" rel="noopener noreferrer';
  } else {
    $qwer = $apply_link;
  }

  $co_logo_wrapper = "";
  if ($company->co_logo != "") {
    $e_co_logo = esc_url($company->co_logo);
    $e_co_logo_alt = esc_attr($company->co_name . 'のロゴ');
    $co_logo_wrapper = <<<EOF
    <div class="job-list-img-wrapper">
      <img
      src="{$e_co_logo}"
      alt="{$e_co_logo_alt}"
      width="100%"
      height="100%"
      />
    </div>
EOF;
  }

  $sector = "";
  switch ($company->co_sector) {
    case "1":
      $sector = "金融・保険";
      break;
    case "2":
      $sector = "建設・不動産";
      break;
    case "3":
      $sector = "コンサルティング・士業";
      break;
    case "4":
      $sector = "IT・インターネット";
      break;
    case "5":
      $sector = "メーカー・商社";
      break;
    case "6":
      $sector = "流通・小売・サービス";
      break;
    case "7":
      $sector = "メディカル";
      break;
    case "8":
      $sector = "マスコミ・メディア";
      break;
    case "9":
      $sector = "エンターテインメント";
      break;
    case "10":
      $sector = "運輸・物流";
      break;
    case "11":
      $sector = "エネルギー";
      break;
    case "12":
      $sector = "その他";
      break;
  }

  $recruitment_type_text = "";
  if ($recruitment_type == "new_graduate") {
    $recruitment_type_text .= "新卒";
  } else if ($recruitment_type == "mid_career") {
    $recruitment_type_text .= "中途";
  } else {
    $recruitment_type_text .= "新卒 / 中途";
  }

  $zipcode_text = $zipcode != "" ? "〒" . $zipcode : "";
  $co_zipcode_text = $company->co_zip_code != "" ? "〒" . $company->co_zip_code : "";

  // ヒアドキュメント内では関数を呼べないため、埋め込む前にエスケープした変数を用意する
  // 仕事内容・募集要項・PR は TinyMCE のリッチテキスト入力で HTML を含む前提のため、
  // esc_html() ではなく wp_kses_post() で許可タグを絞る
  $e_title = esc_html($title);
  $e_work_detail = wp_kses_post($work_detail);
  $e_application_conditions = wp_kses_post($application_conditions);
  $e_working_conditions = wp_kses_post($working_conditions);
  $e_qwert = esc_html($qwert);
  $e_position = esc_html($position);
  $e_recruitment_type_text = esc_html($recruitment_type_text);
  $e_zipcode_text = esc_html($zipcode_text);
  $e_address = esc_html($address);
  $e_address_2 = esc_html($address_2);
  $e_map_query = esc_url('https://maps.google.com/maps?q=' . $address . $address_2 . '&zoom=14&size=512x512&maptype=roadmap&sensor=false');
  $e_can_remote_work = esc_html($can_remote_work);
  $e_sector = esc_html($sector);
  $e_co_name = esc_html($company->co_name);
  $e_co_office_hours = wp_kses_post($company->co_office_hours);
  $e_co_day_off = wp_kses_post($company->co_day_off);
  $e_co_employee_benefits = wp_kses_post($company->co_employee_benefits);
  $e_co_pr_point = wp_kses_post($company->co_pr_point);
  $e_co_zipcode_text = esc_html($co_zipcode_text);
  $e_co_address = esc_html($company->co_address);
  $e_co_address2 = esc_html($company->co_address2);
  $e_co_map_query = esc_url('https://maps.google.com/maps?q=' . $company->co_address . $company->co_address2 . '&zoom=14&size=512x512&maptype=roadmap&sensor=false');
  $e_co_url = esc_url($company->co_url);
  $e_co_url_text = esc_html($company->co_url);
  $e_apply_link = esc_url($qwer);

  $html = <<<EOF
  <div class="job-opening-card" id="job-opening-card">
    <div class="header-wrapper">
      <div class="container-header">
        <h3 class="job-opening-title">{$e_title}</h3>
        <div class="job-list-tag-box">
          <ul class="job-list-tag">
            <span>{$tags}</span>
          </ul>
        </div>
      </div>
    </div>

    <div class="main-box">
      {$co_logo_wrapper}

      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">仕事内容</h1>
        </div>
        <div class="work-detail-text-box">
          <div class="work-detail-text">{$e_work_detail}</div>
        </div>

        <div class="assignments">
          <div class="assignment">
            <div class="assignment-item-label">職種 /<br />募集ポジション</div>
            <div class="assignment-item-value">
              <div>{$e_qwert}</div>
              <div>{$e_position}</div>
            </div>
          </div>

          <div class="assignment">
            <div class="assignment-item-label">新卒 / 中途</div>
            <div class="assignment-item-value">
              <div>{$e_recruitment_type_text}</div>
            </div>
          </div>

          <div class="assignment">
            <div class="assignment-item-label">待遇・労働条件など</div>
            <div class="assignment-item-value">
              <div>{$e_working_conditions}</div>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">勤務地</div>
            <div class="assignment-item-value">
              <a href="{$e_map_query}" class="google-map-address"
              >{$e_zipcode_text}  {$e_address} {$e_address_2}</a> {$e_can_remote_work}</div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">就業時間</div>
            <div class="assignment-item-value">
              <div>{$e_co_office_hours}</div>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">休日・休暇</div>
            <div class="assignment-item-value">
              <div>{$e_co_day_off}</div>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">制度・福利厚生</div>
            <div class="assignment-item-value">
              <div>{$e_co_employee_benefits}</div>
            </div>
          </div>
        </div>
      </div>

      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">募集要項</h1>
        </div>
        <div class="work-detail-text-box">
          <div class="work-detail-text">{$e_application_conditions}</div>
        </div>
      </div>

      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">会社概要</h1>
        </div>

        <div class="assignments">
          <div class="company-information-table-box">
            <div class="assignment">
              <div class="assignment-item-label">会社名</div>
              <div class="assignment-item-value">
                <div>{$e_co_name}</div>
              </div>
            </div>

            <div class="assignment">
              <div class="assignment-item-label">業種</div>
              <div class="assignment-item-value">
                <div>{$e_sector}</div>
              </div>
            </div>

            <div class="assignment">
              <div class="assignment-item-label">本社所在地</div>
              <div class="assignment-item-value">
                <a href="{$e_co_map_query}" class="google-map-address"
                >{$e_co_zipcode_text} {$e_co_address} {$e_co_address2}</a
              >
              </div>
            </div>

            <div class="assignment">
              <div class="assignment-item-label">HP</div>
              <div class="assignment-item-value">
                <div><a href="{$e_co_url}">{$e_co_url_text}</a></div>
              </div>
            </div>
          </div>
        </div>

        <div class="work-detail-text-box">
          <div class="work-detail-text">{$e_co_pr_point}</div>
        </div>
      </div>

      <div class="btn-application-under">
        <a href="{$e_apply_link}" class="btn-application-under-text">応募画面に進む</a>
      </div>
    </div>
  </div>
EOF;
  return $html;
}
