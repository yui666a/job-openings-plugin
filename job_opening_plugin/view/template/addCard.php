<?php

function create_job_opening($user, $action_url, $session_key, $companies)
{
  $companies_selector = '<select name="company_id" id="company_id"> <option value="">--選択してください--</option>';
  foreach ($companies as $data) :
    $companies_selector .= '<option value="' . $data->co_id . '">' . $data->co_name . '</option>';
  endforeach;
  $companies_selector .= '</select>';


  $html = <<<EOF
  <header>
    新規登録
    <span class="close-button"></span>
  </header>

  <!-- main -->
  <div class="job-information">
    <h3>求人情報</h3>
    <form action="{$action_url}" method="post" class="TODO">
      <input type="hidden" name="post_method" value="Y">
      <input type="hidden" name="userId" value="{$user->ID}">
      <input type="hidden" name="ticket" value="{$session_key}">

      <div class="form-item">
        <div class="item-label">募集企業名</div>
        {$companies_selector}
        <div class="form-description">
          任意のID（貴社内の求人管理ID等）または，URLをご入力いただけます
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
          <span class="required-tag">必須</span>部署・役職名
        </div>
        <select id="position" name="position" multiple required></select>
        <button class="add" type="button">＋追加</button>
        <div class="form-description">
          募集されるポジション（役職または部署）を記載してください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>仕事内容
        </div>
        <textarea name="work_detail" rows="6" required></textarea>
        <div class="form-description">
          仕事内容やミッションをわかりやすくご記載ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">労働条件</div>
        <textarea name="working_conditions" rows="6"></textarea>
        <div class="form-description"></div>
      </div>

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

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>リモートワーク
        </div>
        <label>
          <input type="radio" name="remote_work" value="サンプル" />
          可
        </label>
        <label>
          <input type="radio" name="remote_work" value="サンプル" />
          不可
        </label>
        <label>
          <input
            type="radio"
            name="remote_work"
            value="サンプル"
            required
          />
          どちらでも
        </label>
      </div>

      <div class="form-item">
        <div class="item-label"><span class="required-tag">必須</span>職種</div>
        <select name="occupation" id="occupation">
          <option value="">--選択してください--</option>
          <option value="dog">営業</option>
          <option value="cat">事務・管理</option>
          <option value="hamster">企画・マーケティング・経営・管理職</option>
          <option value="parrot">サービス・販売・外食</option>
          <option value="spider">Web・インターネット・ゲーム</option>
          <option value="goldfish">クリエイティブ（メディア・アパレル・デザイン）</option>
          <option value="dog">専門職（コンサルタント・士業・金融・不動産）</option>
          <option value="dog">ITエンジニア（システム開発・SE・インフラ）</option>
          <option value="dog">エンジニア（機械・電気・電子・半導体・制御）</option>
          <option value="dog">素材・化学・食品・医薬品技術職</option>
          <option value="dog">建築・土木技術職</option>
          <option value="dog">技能工・設備・交通・運輸</option>
          <option value="dog">医療・福祉・介護</option>
          <option value="dog">教育・保育・公務員・農林水産・その他</option>
        </select>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>掲載期間
        </div>

        <div style="margin-bottom: 4px">
          <input type="radio" name="date_period" value="" checked />
          本日から
          <input type="tel" id="start" name="trip_period" style="width: 50px" />
          日間表示する
        </div>
        <div>
          <input type="radio" name="date_period" value="" />
          <input type="date" id="start" name="trip_start" />
          　〜　
          <input type="date" id="start" name="trip_last" />
        </div>
      </div>

      <div class="form-buttons">
        <input type="submit" class="button draft" value="下書き保存" />
        <div style="margin-left: 8px">
          <input type="submit" class="button confirm" value="投稿する" />
        </div>
      </div>
    </form>
  </div>
EOF;
  return $html;
}
