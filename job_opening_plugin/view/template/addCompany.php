<?php

function create_company_template($user, $action_url, $session_key)
{
  $html = <<<EOF

  <div class="company-information">
    <h3>企業情報</h3>
    <form action="{$action_url}" method="post" class="TODO" name="TODO">
      <input type="hidden" name="post_method" value="Y">
      <input type="hidden" name="userId" value="{$user->ID}">
      <input type="hidden" name="ticket" value="{$session_key}">

      <div class="form-item">
        <div class="item-label">募集企業名</div>
        <input
          type="text"
          name="company_name"
          id="name"
          value="{$user->display_name}"
          placeholder="株式会社 XXXX-XXXX HOLDINGS"
        />
        <div class="form-description">
          未入力の場合は，貴社アカウント名で登録されます
        </div>
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
          <span class="required-tag">必須</span>PR文
        </div>
        <textarea name="company_pr" rows="6" required></textarea>
        <div class="form-description">
          貴社の強みや，メリットなどPR文をお書きください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>本社所在地
        </div>

        〒<input type="text" name="company_zipcode" required placeholder="999-9999" style="width: 100px;"></input>
        <input type="text" name="company_address" placeholder="〇〇県〇〇市９−９−９ △△ビル 3F" required></input>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>過去の実績
        </div>
        <textarea name="company_achievement" rows="6" required></textarea>
        <div class="form-description">
          TODO
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>勤務時間
        </div>
        <textarea name="company_office_hour" rows="6" required></textarea>
        <div class="form-description">
          TODO
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>待遇・福利厚生・支援制度など
        </div>
        <textarea name="company_benefits" rows="6" required></textarea>
        <div class="form-description">
          TODO
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>休日・休暇
        </div>
        <textarea name="company_day_off" rows="6" required></textarea>
        <div class="form-description">
          TODO
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
