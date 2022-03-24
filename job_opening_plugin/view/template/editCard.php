<?php

function edit_job_opening($user, $action_url, $session_key, $companies, $job_id)
{
  $post = get_post($job_id, "ARRAY_A");
  $published_date = explode(" ", $post["post_date"])[0];
  $expired_date = get_post_meta($job_id, '_expired_date', true);
  $company_id = get_post_meta($job_id, '_company_id', true);
  $recruitment_type =  get_post_meta($job_id, '_recruitment_type', true);
  $apply_link = get_post_meta($job_id, '_apply_link', true);
  $manage_id = get_post_meta($job_id, '_manage_id', true);
  $title = get_post_meta($job_id, '_title', true);
  $work_detail =  get_post_meta($job_id, '_work_detail', true);
  $application_conditions =  get_post_meta($job_id, '_application_conditions', true);
  $position = get_post_meta($job_id, '_position', true);
  $working_conditions = get_post_meta($job_id, '_working_conditions', true);
  $occupation = get_post_meta($job_id, '_occupation', true);
  $remote_work = get_post_meta($job_id, '_remote_work', true);
  $zipcode = get_post_meta($job_id, '_zipcode', true);
  $address = get_post_meta($job_id, '_address', true);
  $address_2 = get_post_meta($job_id, '_address_2', true);
  get_post_meta($job_id, '_location', true);

  // 企業セレクタの作成
  $companies_selector = '<select name="company_id" id="company_id">';
  session_start();
  $multi_dimensional_array = array();
  foreach ($companies as $data) :
    $isSelected = $data->co_id == $company_id  ? 'selected' : '';
    $companies_selector .= '<option value="' . $data->co_id . '" ' . $isSelected . '>' . $data->co_name . '</option>';

    $multi_dimensional_array[] = array(
      'co_id' => $data->co_id,
      'co_name' => $data->co_name,
      'co_sector' => $data->co_sector,
      'co_url' => $data->co_url,
      'co_pr_point' => $data->co_pr_point,
      'co_zip_code' => $data->co_zip_code,
      'co_address' => $data->co_address,
      'co_achievement' => $data->co_achievement,
      'co_office_hours' => $data->co_office_hours,
      'co_employee_benefits' => $data->co_employee_benefits,
      'co_day_off' => $data->co_day_off,
    );
  endforeach;
  $companies_selector .= '</select>';
  $encoded_data = json_encode($multi_dimensional_array);
  $companies_data = htmlspecialchars($encoded_data, ENT_COMPAT | ENT_HTML401, 'UTF-8');

  // 求人管理URL
  $manage_id = "";
  if ($manage_id == "") {
    $manage_id = '<input type="text" name="manage_id" id="manage_id" placeholder="35470, https://~~~ など" />';
  } else {
    $manage_id = '<input type="text" name="manage_id" id="manage_id" placeholder="35470, https://~~~ など" value=' . $manage_id . '/>';
  }

  // 求人タイプ
  $recruitment_options = array(["新卒", "new_graduate"], ["中途", "mid_career"], ["どちらでも", "both"]);
  $recruitment_radio = "";
  foreach ($recruitment_options as $option) {
    $isChecked = $option[1] == $recruitment_type  ? 'checked' : '';
    $recruitment_radio .= '<label> <input required type="radio" ' . $isChecked . ' name="recruitment_type" class="recruitment_type" value="' . $option[1] . '" />' . $option[0] . '</label>';
  }

  $encoded_data = json_encode($occupation);
  $selected_occupations_data = htmlspecialchars($encoded_data, ENT_COMPAT | ENT_HTML401, 'UTF-8');

  // リモートワーク
  $remote_options = array(["可", "true"], ["不可", "false"], ["未選択", "both"]);
  $remote_radio = "";
  foreach ($remote_options as $option) {
    $isChecked = $option[1] == $remote_work  ? 'checked' : '';
    $remote_radio .= '<label> <input required type="radio" ' . $isChecked . ' name="remote_work" class="remote_work" value="' . $option[1] . '" />' . $option[0] . '</label>';
  }

  $html = header_link_buttons();
  $html .= <<<EOF
  <!-- main -->
  <div class="job-information">
    <h3>求人情報</h3>
    <form action="{$action_url}" method="post" class="h-adr">
      <input type="hidden" name="post_method" value="Y">
      <input type="hidden" name="userId" value="{$user->ID}">
      <input type="hidden" name="ticket" value="{$session_key}">
      <input type="hidden" name="companies_data" value="{$companies_data}">
      <input type="hidden" name="selected_occupations" value="{$selected_occupations_data}">

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          募集企業名
        </div>
        {$companies_selector}
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          求人名（表示するタイトル）
        </div>
        <input required type="text" name="title" id="title" placeholder="" value="{$title}"/>
        <div class="form-description">
          求人ページの見出し(求人名)をご入力いただけます
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          応募URLや宛先メールアドレス
        </div>
        <input required type="text" name="apply_link" id="apply_link" placeholder="https://~, xxx@gmail.com" value="{$apply_link}"/>
        <div class="form-description">
          応募者が遷移するURLや宛先eメールアドレスをご入力ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">求人管理</div>
          {$manage_id}
        <div class="form-description">
          任意のID（貴社内の求人管理ID等）または，URLをご入力いただけます
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          求人タイプ
        </div>
        {$recruitment_radio}
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          職種
        </div>
        <select name="occupation[]" id="occupation" multiple="multiple" required></select>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>部署・役職名
        </div>
        <input type="text" required placeholder="" name="position" class="position" value="{$position}" />
        <div class="form-description">
          募集されるポジション（役職または部署）を記載してください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          仕事内容
        </div>
        <textarea class="rich" name="work_detail" rows="6" required>{$work_detail}</textarea>
        <div class="form-description">
          仕事内容やミッションをわかりやすくご記載ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          募集要件
        </div>
        <textarea class="rich" name="application_conditions" rows="6" required>{$application_conditions}</textarea>
        <div class="form-description">
          必須条件、歓迎条件、求める人物像などをご記載ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          待遇・労働条件など
        </div>
        <textarea required class="rich" name="working_conditions" rows="6">{$working_conditions}</textarea>
        <div class="form-description">雇用形態や労働契約の期間、待遇などについてご記入ください</div>
      </div>

      <!--
      <div class="form-item">
        <div class="item-label"><span class="required-tag">必須</span>勤務地</div>
        <select id="location" name="location" multiple required></select>
        <button class="add" type="button">＋追加</button>

        <div>
          <label>
            <input type="checkbox" name="example" value="サンプル" />
            勤務地問わず
          </label>
        </div>
      </div>
      -->

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          リモートワーク
        </div>
        {$remote_radio}
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="recommended-tag">任意</span>
          勤務地住所
        </div>
        <input type="hidden" class="p-country-name" value="Japan">
        〒<input type="text" value="{$zipcode}" placeholder="999-9999" name="zipcode" class="p-postal-code" size="8" maxlength="8" style="width: 130px;"><br>
        <input type="text" value="{$address}" placeholder="〇〇県〇〇市９−９−９" name="address" class="p-region p-locality p-street-address p-extended-address" /><br>
        <input type="text" value="{$address_2}" placeholder="△△ビル 3F" name="address_2" class="" /><br>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          掲載期間
        </div>

        <div>
          <input type="date" id="start" name="trip_start" value="{$published_date}" style="width:40%"/>
          　〜　
          <input type="date" id="start" name="trip_last" value="{$expired_date}" style="width:40%"/>
        </div>
      </div>

      <div class="form-buttons">
        <button type="submit" class="button draft" name='action' value='reset'>リセット</button>
        <div style="margin-left: 8px">
          <button type="submit" class="button draft" name='action' value='draft'>下書き保存</button>
        </div>
        <div style="margin-left: 8px">
          <button type='submit' class="button confirm" name='action' value='update'>更新する</button>
        </div>
      </div>
    </form>
  </div>
EOF;
  return $html;
}
