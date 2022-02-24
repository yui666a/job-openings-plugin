<?php

function create_company() {
$html = '
<header>
  新規登録
  <span class="close-button"></span>
</header>

<!-- main -->
<div class="company-information">
<h3>企業情報</h3>
<form action="" method="get" class="TODO">
  <div class="form-item">
    <div class="item-label">企業HP URL</div>
    <input type="text" name="name" id="name" placeholder="https://~~~" />
    <div class="form-description">
      貴社ホームページのURLをご入力いただけます
    </div>
  </div>

  <div class="form-item">
    <div class="item-label">
      <span class="required-tag">必須</span>PR文
    </div>
    <textarea name="work-detail" rows="6" required></textarea>
    <div class="form-description">
      貴社の強みや，メリットなどPR文をお書きください
    </div>
  </div>

  <div class="form-item">
    <div class="item-label">
      <span class="required-tag">必須</span>本社所在地
    </div>
    
    〒<input type="text" name="work-detail" required placeholder="999-9999" style="width: 100px;"></input>
    <input type="text" name="work-detail" placeholder="〇〇県〇〇市９−９−９ △△ビル 3F" required></input>
  </div>

  <div class="form-buttons">
    <div style="margin-left: 8px">
      <input type="submit" class="button confirm" value="保存する" />
    </div>
  </div>
</form>
</div>
';
return $html;
}