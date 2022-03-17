<?php

function create_job_opening($user, $action_url, $session_key, $companies)
{
  // 企業セレクタの作成
  $companies_selector = '<select name="company_id" id="company_id"> <option value="" hidden>--選択してください--</option>';
  session_start();
  $multi_dimensional_array = array();
  foreach ($companies as $data) :
    $companies_selector .= '<option value="' . $data->co_id . '">' . $data->co_name . '</option>';
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

  // 求人タイプ
  $recruitment_options = array(["新卒", "new_graduate"], ["中途", "mid_career"], ["どちらでも", "both"]);
  $recruitment_radio = "";
  foreach ($recruitment_options as $option) {
    $recruitment_radio .= '<label> <input required type="radio" name="recruitment_type" class="recruitment_type" value="' . $option[1] . '" />' . $option[0] . '</label>';
  }

  // 職種
  $occupation_options = array(
    ["sales_associate", "営業"],
    ["clerk", "事務・管理"],
    ["marketer", "企画・マーケティング・経営・管理職"],
    ["service", "サービス・販売・外食"],
    ["web", "Web・インターネット・ゲーム"],
    ["creative", "クリエイティブ（メディア・アパレル・デザイン）"],
    ["expert", "専門職（コンサルタント・士業・金融・不動産）"],
    ["it_engineer", "ITエンジニア（システム開発・SE・インフラ）"],
    ["engineer", "エンジニア（機械・電気・電子・半導体・制御）"],
    ["chemical_engineer", "素材・化学・食品・医薬品技術職"],
    ["civil_engineer", "建築・土木技術職"],
    ["transporter", "技能工・設備・交通・運輸"],
    ["medical_welfare", "医療・福祉・介護"],
    ["public_servant", "教育・保育・公務員・農林水産・その他"],
  );
  $occupation_selector = '<select required name="occupation" id="occupation"> <option hidden value="">--選択してください--</option>';
  foreach ($occupation_options as $option) {
    $occupation_selector .= '<option value="' . $option[0] . '">' . $option[1] . '</option>';
  }
  $occupation_selector .= '</select>';

  // リモートワーク
  $remote_options = array(["可", "true"], ["不可", "false"], ["どちらでも", "both"]);
  $remote_radio = "";
  foreach ($remote_options as $option) {
    $remote_radio .= '<label> <input required type="radio" name="remote_work" class="remote_work" value="' . $option[1] . '" />' . $option[0] . '</label>';
  }


  $html =header_link_buttons();
  $html .= <<<EOF
  <!-- main -->
  <form action="{$action_url}" method="post">
    <div class="job-information">
      <h3>求人情報</h3>
      <input type="hidden" name="post_method" value="Y">
      <input type="hidden" name="userId" value="{$user->ID}">
      <input type="hidden" name="ticket" value="{$session_key}">
      <input type="hidden" name="companies_data" value="{$companies_data}">

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>
          募集企業名
        </div>
        {$companies_selector}
      </div>

      <div class="form-item">
        <div class="item-label">求人名（表示するタイトル）</div>
        <input type="text" name="title" id="title" placeholder="" />
        <div class="form-description">
          求人ページの見出し(求人名)をご入力いただけます
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">求人管理</div>
        <input type="text" name="url" id="url" placeholder="35470, https://~~~ など" />
        <div class="form-description">
          任意のID（貴社内の求人管理ID等）または，URLをご入力いただけます
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>求人タイプ
        </div>
        {$recruitment_radio}
      </div>

      <div class="form-item">
        <div class="item-label"><span class="required-tag">必須</span>職種</div>
        {$occupation_selector}
      </div>

      <!--
      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>部署・役職名
        </div>
        <select id="position" name="position" multiple required></select>
        <input type="text" name="add_position" id="add_position" placeholder="など" />
        <button class="add" type="button">＋追加</button>
        <div class="form-description">
          募集されるポジション（役職または部署）を記載してください
        </div>
      </div>
      -->

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>仕事内容
        </div>
        <textarea class="rich" name="work_detail" rows="6" required></textarea>
        <div class="form-description">
          仕事内容やミッションをわかりやすくご記載ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>募集要件
        </div>
        <textarea class="rich" name="application_conditions" rows="6" required></textarea>
        <div class="form-description">
          必須条件、歓迎条件、求める人物像などをご記載ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label"><span class="recommended-tag">歓迎</span>労働条件</div>
        <textarea class="rich" name="working_conditions" rows="6"></textarea>
        <div class="form-description"></div>
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
          <span class="required-tag">必須</span>リモートワーク
        </div>
        {$remote_radio}
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>掲載期間
        </div>

        <div style="margin-bottom: 4px">
          <input type="radio" name="date_period_type" value="period" checked />
          本日から
          <input type="tel" id="start" name="trip_period" value="90" style="width: 50px" />
          日間表示する
        </div>
        <div>
          <input type="radio" name="date_period_type" value="fromto" />
          <input type="date" id="start" name="trip_start" style="width:40%"/>
          　〜　
          <input type="date" id="start" name="trip_last" style="width:40%"/>
        </div>
      </div>
      <div class="form-buttons">
        <button type="submit" class="button draft" name='action' value='draft'>下書き保存</button>
        <button type="submit" class="button confirm" name='action' value='post'>投稿する</button>
      </div>
    </div>










    <!--
    <div class="job-information">
      <h3>企業情報</h3>

      <div class="form-item">
        <div class="item-label">募集企業名</div>
        <input
          type="text"
          name="company_name"
          id="company_name"
          placeholder="株式会社 XXXX-XXXX HOLDINGS"
        />
      </div>

      <div class="form-item">
        <div class="item-label">業種</div>
        <select name="company_sector" id="company_sector">
          <option value="">--選択してください--</option>
          <option value="1">金融・保険</option>
          <option value="2">建設・不動産</option>
          <option value="3">コンサルティング・士業</option>
          <option value="4">IT・インターネット</option>
          <option value="5">メーカー・商社</option>
          <option value="6">流通・小売・サービス</option>
          <option value="7">メディカル</option>
          <option value="8">マスコミ・メディア</option>
          <option value="9">エンターテインメント</option>
          <option value="10">運輸・物流</option>
          <option value="11">エネルギー</option>
          <option value="12">その他</option>
        </select>
      </div>

      <div class="form-item">
        <div class="item-label">企業HP URL</div>
        <input type="text" name="company_url" id="name" placeholder="https://~~~" />
        <div class="form-description">
          貴社ホームページのURLをご入力いただけます
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="recommended-tag">歓迎</span>PR文
        </div>
        <textarea class="rich" name="company_pr" rows="6"></textarea>
        <div class="form-description">
          貴社の強みや，メリットなどPR文をお書きください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
        <span class="required-tag">必須</span>本社所在地
        </div>

        〒<input required type="text" name="company_zipcode" placeholder="999-9999" style="width: 100px;"></input>
        <input type="text" name="company_address" placeholder="〇〇県〇〇市９−９−９ △△ビル 3F" required></input>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="recommended-tag">歓迎</span>過去の実績
        </div>
        <textarea class="rich" name="company_achievement" rows="6"></textarea>
        <div class="form-description">
          貴社のこれまでの実績をご記入ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
        <span class="recommended-tag">歓迎</span>勤務時間
        </div>
        <textarea class="rich" name="company_office_hour" rows="6"></textarea>
        <div class="form-description">
          貴社の普段の勤務時間や営業時間をご記入ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
        <span class="recommended-tag">歓迎</span>待遇・福利厚生・支援制度など
        </div>
        <textarea class="rich" name="company_benefits" rows="6"></textarea>
        <div class="form-description">
          貴社の待遇・福利厚生・支援制度などをご記入ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
        <span class="recommended-tag">歓迎</span>休日・休暇
        </div>
        <textarea class="rich" name="company_day_off" rows="6"></textarea>
        <div class="form-description">
        貴社の休日や休暇面をご記入ください
        </div>
      </div>
      <div class="form-buttons">
        <input type="submit" class="button draft" value="下書き保存" />
        <div style="margin-left: 8px">
          <input type="submit" class="button confirm" value="投稿する" />
        </div>
      </div>
    -->
    </div>
  </form>

EOF;
  return $html;
}
