<?php

/**
 * 掲載期間の入力を検証し、投稿日と掲載終了日を返す。
 *
 * 戻り値は array('post_date' => 投稿日, 'expired_date' => 掲載終了日)
 * または array('error' => エラーメッセージ)。
 *
 * @param string $date_period_type 掲載期間選択タイプ（"period" なら日数指定）
 * @param mixed  $trip_period      日数
 * @param mixed  $trip_start       掲載開始月日（Y-m-d）
 * @param mixed  $trip_last        掲載終了月日（Y-m-d）
 * @return array
 */
function job_opening_resolve_posting_period($date_period_type, $trip_period, $trip_start, $trip_last)
{
  // サイトの設定タイムゾーンで日付を組み立てる。既定では PHP の date.timezone（多くの環境で UTC）が
  // 使われ、WordPress の設定と最大で丸一日ずれた掲載開始・終了日になる。
  $timezone = wp_timezone();
  $now = new DateTime('now', $timezone);

  if ($date_period_type == "period") {
    // absint() は使わない。'1 day + 100 year' の先頭の数字だけを拾って 1 と解釈し、
    // '-5' を 5 に変えてしまうため、不正な入力が「有効な日数」として通り抜ける。
    // modify() は日付操作の DSL を解釈するので、数字だけからなる入力に限って受け付ける。
    $is_digits = (is_string($trip_period) || is_int($trip_period)) && ctype_digit((string) $trip_period);
    $days = $is_digits ? (int) $trip_period : 0;

    if ($days < 1 || $days > JOB_OPENING_MAX_POSTING_DAYS) {
      return array('error' => '掲載日数は1日以上' . JOB_OPENING_MAX_POSTING_DAYS . '日以内で指定してください。');
    }

    $expires = clone $now;
    $expires->modify('+' . $days . ' day');

    return array(
      'post_date'    => $now->format('Y-m-d H:i:s'),
      'expired_date' => $expires->format('Y-m-d'),
    );
  }

  $start = job_opening_parse_date($trip_start, $timezone);
  if (!$start) {
    return array('error' => '掲載開始日の形式が正しくありません。');
  }

  $last = job_opening_parse_date($trip_last, $timezone);
  if (!$last) {
    return array('error' => '掲載終了日の形式が正しくありません。');
  }

  if ($last < $start) {
    return array('error' => '掲載終了日は掲載開始日以降の日付を指定してください。');
  }

  return array(
    'post_date'    => $start->format('Y-m-d H:i:s'),
    'expired_date' => $last->format('Y-m-d'),
  );
}

/**
 * Y-m-d 形式の文字列を DateTime にする。解釈できなければ false を返す。
 *
 * new DateTime() は不正な文字列に対して例外を投げ、捕捉しなければ Fatal error で
 * 白画面になる。戻り値で失敗を表せる createFromFormat() を使う。
 *
 * @param mixed        $value
 * @param DateTimeZone $timezone
 * @return DateTime|false
 */
function job_opening_parse_date($value, $timezone)
{
  if (!is_string($value) || $value === '') {
    return false;
  }

  $date = DateTime::createFromFormat('Y-m-d', $value, $timezone);
  // createFromFormat() は '2026-02-31' のような存在しない日付を繰り上げて受理するため、
  // 整形し直した文字列と入力が一致するかで妥当性を確かめる。
  if (!$date || $date->format('Y-m-d') !== $value) {
    return false;
  }

  // 時刻を指定しない createFromFormat() は現在時刻を埋めるため、日付の比較がぶれる。
  $date->setTime(0, 0, 0);

  return $date;
}
