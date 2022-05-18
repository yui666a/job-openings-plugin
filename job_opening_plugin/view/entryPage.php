<?php

function entryPage()
{
  $html = '
<div class="jo-entry">
  <div class="page-area">
    <div class="left-area">
      <div class="img-wrapper">
        <img
          src="https://nagaoka-worker.jp/wp-content/uploads/2022/04/icon-co-add.png"
        />
      </div>
    </div>
    <div class="text-wrapper">
      <div class="title">企業を新規追加</div>
      <div class="description">
        求人情報を投稿したい企業情報を新たに作成します
      </div>
      <div>
        <a href="/add_company" class="btn">ページに移動する</a>
      </div>
    </div>
  </div>

  <div class="page-area">
    <div class="left-area">
      <div class="img-wrapper">
        <img
          src="https://nagaoka-worker.jp/wp-content/uploads/2022/04/icon-co-list.png"
        />
      </div>
    </div>
    <div class="text-wrapper">
      <div class="title">作成した企業一覧</div>
      <div class="description">作成した企業情報を確認・修正できます</div>
      <div>
        <a href="/company_list" class="btn">ページに移動する</a>
      </div>
    </div>
  </div>

  <div class="page-area">
    <div class="left-area">
      <div class="img-wrapper">
        <img
          src="https://nagaoka-worker.jp/wp-content/uploads/2022/04/icon-jo-add.png"
        />
      </div>
    </div>
    <div class="text-wrapper">
      <div class="title">求人情報を新規追加</div>
      <div class="description">求人情報を新たに作成します</div>
      <div>
        <a href="/add_job_opening" class="btn">ページに移動する</a>
      </div>
    </div>
  </div>

  <div class="page-area">
    <div class="left-area">
      <div class="img-wrapper">
        <img
          src="https://nagaoka-worker.jp/wp-content/uploads/2022/04/icon-jo-list.png"
        />
      </div>
    </div>
    <div class="text-wrapper">
      <div class="title">作成した求人一覧</div>
      <div class="description">作成した企業情報を確認・修正できます</div>
      <div>
        <a href="/job_opening_list" class="btn">ページに移動する</a>
      </div>
    </div>
  </div>
</div>';

  return $html;
}
