<?php

function entryPage()
{
  $html ='<article><nav class="global"><ul>
    <a href="/add_job_opening" class="btn">求人情報を新規追加</a>
    <a href="/job_opening_list" class="btn">作成した求人一覧</a>
    <a href="/add_company" class="btn">企業情報に新規追加</a>
    <a href="/company_list" class="btn">作成した企業一覧</a>
  </ul></nav></article>';
  return $html;
}
