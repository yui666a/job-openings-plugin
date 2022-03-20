<?php

function create_company_template($user, $action_url, $session_key)
{

  // 業種
  $sector_options = array(
    ["1", "金融・保険"],
    ["2", "建設・不動産"],
    ["3", "コンサルティング・士業"],
    ["4", "IT・インターネット"],
    ["5", "メーカー・商社"],
    ["6", "流通・小売・サービス"],
    ["7", "メディカル"],
    ["8", "マスコミ・メディア"],
    ["9", "エンターテインメント"],
    ["10", "運輸・物流"],
    ["11", "エネルギー"],
    ["12", "その他"],
  );
  $sector_selector = '<select required name="company_sector" id="company_sector"> <option hidden value="">--選択してください--</option>';
  foreach ($sector_options as $option) {
    $sector_selector .= '<option value="' . $option[0] . '">' . $option[1] . '</option>';
  }
  $sector_selector .= '</select>';


  $html = header_link_buttons();
  $html .= <<<EOF
  <div class="company-information">
    <h3>企業情報</h3>
    <form action="{$action_url}" method="post" enctype="multipart/form-data" class="h-adr">
      <input type="hidden" name="post_method" value="Y">
      <input type="hidden" name="userId" value="{$user->ID}">
      <input type="hidden" name="ticket" value="{$session_key}">

      <div class="form-item">
        <div class="item-label"> <span class="required-tag">必須</span>募集企業名</div>
        <input
          required
          type="text"
          name="company_name"
          id="name"
          value="{$user->display_name}"
          placeholder="株式会社 XXXX-XXXX HOLDINGS"
        />
      </div>

      <div class="form-item">
        <div class="item-label"><span class="recommended-tag">歓迎</span>企業ロゴ</div>
        <input type="file" name="company_logo" id="company_logo" accept="image/*">
        <div class="form-description">
          貴社ロゴを挿入いただけます(約15MB以下のファイルに限ります)
        </div>
        Preview:<br>
        <img id="logo_preview" style="width:auto;height:200px;" >
      </div>

      <div class="form-item">
        <div class="item-label"> <span class="required-tag">必須</span>業種</div>
        {$sector_selector}
      </div>

      <div class="form-item">
        <div class="item-label"> <span class="recommended-tag">歓迎</span>企業HP URL</div>
        <input type="text" name="company_url" id="name" placeholder="https://~~~" />
        <div class="form-description">
          貴社ホームページのURLをご入力いただけます
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="recommended-tag">歓迎</span>会社概要
        </div>
        <textarea class="rich" name="company_summary" rows="6"></textarea>
        <div class="form-description">
          募集企業の概要をご記載ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="recommended-tag">歓迎</span>PR文
        </div>
        <textarea class="rich" name="company_pr" rows="6"></textarea>
        <div class="form-description">
          貴社の強みなどPR文をお書きください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="recommended-tag">歓迎</span>本社所在地
        </div>
        <input type="hidden" class="p-country-name" value="Japan">
        〒<input type="text" placeholder="999-9999" name="company_zipcode" class="p-postal-code" size="8" maxlength="8" style="width: 130px;"><br>
        <input type="text" placeholder="〇〇県〇〇市９−９−９" name="company_address" class="p-region p-locality p-street-address p-extended-address" /><br>
        <input type="text" placeholder="△△ビル 3F" name="company_address_2" class="" /><br>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>勤務時間
        </div>
        <textarea required class="rich" name="company_office_hour" rows="6"></textarea>
        <div class="form-description">
          貴社の普段の勤務時間や営業時間をご記入ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>福利厚生・支援制度など
        </div>
        <textarea required class="rich" name="company_benefits" rows="6"></textarea>
        <div class="form-description">
          貴社の福利厚生・支援制度などをご記入ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>休日・休暇
        </div>
        <textarea required class="rich" name="company_day_off" rows="6"></textarea>
        <div class="form-description">
          貴社の休日や休暇面をご記入ください
        </div>
      </div>

      <div class="form-buttons">
        <div style="margin-left: 8px">
          <input type="submit" class="button confirm" value="保存する" />
        </div>
      </div>
    </form>
  </div>
EOF;
  return $html;
}
