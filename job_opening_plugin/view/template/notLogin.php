<?php

function notLogin()
{
  return '<div style="margin: 8%;"><strong>このページは閲覧できません．ログインしてください</strong>
  <div><button class="button confirm" onclick="location.href=\''.wp_login_url(get_permalink()).'\'">ログイン画面へ</button></div></div>';
}




