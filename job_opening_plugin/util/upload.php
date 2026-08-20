<?php

/**
 * 企業ロゴをアップロードし、保存先の URL を返す。
 *
 * 戻り値は array('url' => 保存先URL) または array('error' => エラーメッセージ)。
 * ファイルが選択されていない場合は空配列を返す。
 *
 * @param array $file $_FILES の1要素
 * @return array
 */
function job_opening_handle_company_logo_upload($file)
{
  if (empty($file) || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE || empty($file['name'])) {
    return array();
  }

  require_once ABSPATH . 'wp-admin/includes/file.php';

  // 保存先を sac_jo/company_images に寄せる。wp_upload_dir() の戻り値を書き換える方法しか
  // wp_handle_upload() に保存先を伝える手段がないため、フィルタを一時的に掛けて直後に外す。
  // 外さないと同一リクエスト内の他プラグインのアップロード先まで変わる。
  $redirect_upload_dir = function ($dirs) {
    $dirs['subdir'] = '/sac_jo/company_images';
    $dirs['path'] = $dirs['basedir'] . $dirs['subdir'];
    $dirs['url'] = $dirs['baseurl'] . $dirs['subdir'];
    return $dirs;
  };
  add_filter('upload_dir', $redirect_upload_dir);
  $uploaded = wp_handle_upload(
    $file,
    array(
      // 独自フォームからの POST のため、WordPress 標準の action フィールド検証は通らない
      'test_form' => false,
      'mimes' => array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
      ),
    )
  );
  remove_filter('upload_dir', $redirect_upload_dir);

  if (isset($uploaded['error'])) {
    return array('error' => $uploaded['error']);
  }

  return array('url' => $uploaded['url']);
}
