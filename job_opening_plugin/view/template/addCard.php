<?php

function create_job_opening($user)
{
  $html = '
  <header>
    新規登録
    <span class="close-button"></span>
  </header>

  <!-- main -->
  <div class="job-information">
    <h3>求人情報</h3>
    <form action="" method="get" class="TODO">
      <div class="form-item">
        <div class="item-label">求人管理</div>
        <input type="text" id="url" placeholder="35470, https://~~~ など" />
        <div class="form-description">
          任意のID（貴社内の求人管理ID等）または，URLをご入力いただけます
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>部署・役職名
        </div>
        <select id="position" multiple required></select>
        <button class="add" type="button">＋追加</button>
        <div class="form-description">
          募集されるポジション（役職または部署）を記載してください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>仕事内容
        </div>
        <textarea name="work-detail" rows="6" required></textarea>
        <div class="form-description">
          仕事内容やミッションをわかりやすくご記載ください
        </div>
      </div>

      <div class="form-item">
        <div class="item-label">労働条件</div>
        <textarea name="Working-conditions" rows="6"></textarea>
        <div class="form-description"></div>
      </div>

      <div class="form-item">
        <div class="item-label"><span class="required-tag">必須</span>勤務地</div>
        <select id="location" multiple required></select>
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
          <input type="radio" name="remote-work" value="サンプル" />
          可
        </label>
        <label>
          <input type="radio" name="remote-work" value="サンプル" />
          不可
        </label>
        <label>
          <input
            type="radio"
            name="remote-work"
            value="サンプル"
            required
          />
          どちらでも
        </label>
      </div>

      <div class="form-item">
        <div class="item-label"><span class="required-tag">必須</span>職種</div>
        <select id="occupation" multiple></select>
        <button disabled class="add" type="button">＋追加</button>
        <input
          type="text"
          id="occupation"
          style="width: calc(100% - 80px * 2)"
          placeholder="新しく追加する職種を入力してください"
        />
        <button class="add-confirm" type="button">確定</button>
      </div>

      <div class="form-item">
        <div class="item-label">
          <span class="required-tag">必須</span>掲載期間
        </div>

        <div style="margin-bottom: 4px">
          <input type="radio" name="date-period" value="" checked />
          本日から
          <input type="tel" id="start" name="trip-start" style="width: 50px" />
          日間表示する
        </div>
        <div>
          <input type="radio" name="date-period" value="" />
          <input type="date" id="start" name="trip-start" />
          　〜　
          <input type="date" id="start" name="trip-start" />
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
  ';
  return $html;
}
