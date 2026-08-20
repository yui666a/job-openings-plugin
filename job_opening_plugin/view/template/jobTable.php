<?php

function make_job_openings_table_row($post_id, $title, $author, $post_date, $job_expires, $job_location, $status_icon, $permalink)
{
  $admin_url = esc_url(get_admin_url(''));
  $delete_url = wp_nonce_url($admin_url . "post.php?post=" . $post_id . "&amp;action=trash", 'trash-post_' . $post_id);
  $job_table_url = HOME_URL . "/" . get_option("sac_job_openings_list");
  $current_request = $_SERVER["REQUEST_URI"];
  $company_id = get_post_meta($post_id, '_company_id', true);
  $manage_id = get_post_meta($post_id, '_manage_id', true);
  $company = getCompanyById($company_id);

  $recruitment_type = "";
  switch (get_post_meta($post_id, '_recruitment_type', true)) {
    case "new_graduate":
      $recruitment_type = "新卒";
      break;
    case "mid_career":
      $recruitment_type = "中途";
      break;
    case "both":
      $recruitment_type = "新卒・中途";
      break;
    default:
      $recruitment_type = "";
      break;
  };

  // 公開状態の切り替えは GET だけで発火するため、リンク自体に nonce を持たせる
  // wp_nonce_url() は内部で esc_html() を通すため、ここで重ねてエスケープしない
  $publish_url = wp_nonce_url($job_table_url . "?&action=publish&post=" . $post_id, 'job_opening_publish_job_' . $post_id, 'ticket');
  $draft_url = wp_nonce_url($job_table_url . "?&action=draft&post=" . $post_id, 'job_opening_draft_job_' . $post_id, 'ticket');

  // ヒアドキュメント内では関数を呼べないため、埋め込む前にエスケープした変数を用意する
  $e_title = esc_html($title);
  $e_manage_id = esc_html($manage_id);
  $e_recruitment_type = esc_html($recruitment_type);
  $e_co_name = esc_html($company->co_name);
  $e_co_logo = esc_url($company->co_logo);
  $e_co_name_attr = esc_attr($company->co_name);
  $e_job_location = esc_html($job_location);
  $e_map_url = esc_url('https://maps.google.com/maps?q=' . $job_location . '&zoom=14&size=512x512&maptype=roadmap&sensor=false');
  $e_permalink = esc_url($permalink);
  $e_current_request = esc_url($current_request);
  $e_post_date = esc_html($post_date);
  $e_job_expires = esc_html($job_expires);

  $post_status_link = "";
  if (get_post_status($post_id) == "draft") {
    $post_status_link = <<<EOF
    <a
      class="button button-icon tips icon-view"
      href="{$publish_url}"
      data-tip="公開する"
      >公開する</a
      >
EOF;
  } else {
    $post_status_link = <<<EOF
    <a
      class="button button-icon tips icon-view"
      href="{$draft_url}"
      data-tip="非公開にする"
      >非公開にする</a
      >
EOF;
  }

  $job_openings_table_main = <<<EOF
    <tr
      id="post-{$post_id}"
      class="iedit author-self level-0 post-{$post_id} type-job_listing status-publish has-post-thumbnail hentry job_listing job-type-full-time"
    >
      <td
        class="job_position column-job_position has-row-actions column-primary"
        data-colname="求人タイトル"
      >
        <div class="job_position">
          <a
            href="{$e_current_request}?&action=edit&post={$post_id}"
            class="tips job_title"
            data-tip="ID: {$post_id}"
            >{$e_title}</a
          ><br/>(管理番号: {$e_manage_id})
        </div>
      </td>
      <td
        class="job_listing_type column-job_listing_type"
        data-colname="タイプ"
      >
        <span class="job-type">{$e_recruitment_type}</span>
      </td>
      <td class="job_location column-job_location" data-colname="社名・勤務地">
        <div class="company">
          <span class="tips" data-tip="asdf">
            {$e_co_name}
          </span>
        </div>
        <img
          class="company_logo"
          src="{$e_co_logo}"
          alt="{$e_co_name_attr}"
        />
        <a
          class="google_map_link"
          href="{$e_map_url}"
          >{$e_job_location}</a
        >
      </td>
      <td class="job_status column-job_status" data-colname="ステータス">
        {$status_icon}
      </td>
      <td class="job_posted column-job_posted" data-colname="期限">
        <strong>{$e_post_date}<br/>〜 {$e_job_expires}</strong>
      </td>
      <!--<td
        class="job_listing_category column-job_listing_category"
        data-colname="カテゴリー"
      >
        <span class="na">–</span>
      </td>-->
      <td class="job_actions column-job_actions" data-colname="操作">
        <div class="actions">
          <div>
            <a
              class="button button-icon tips icon-view"
              href="{$e_permalink}"
              data-tip="表示"
              >表示</a
            >
          </div>
          <div>
            <a
              class="button button-icon tips icon-edit"
              href="{$e_current_request}?&action=edit&post={$post_id}"
              data-tip="編集"
              >編集</a
            >
          </div>
          <div>
            <a
              class="button button-icon tips icon-delete"
              href="{$delete_url}"
              data-tip="削除"
              >削除</a
            >
          </div>
          <div>
            {$post_status_link}
          </div>
          <div>
            <a
              class="button button-icon tips icon-edit"
              href="{$e_current_request}?&action=copy&post={$post_id}"
              data-tip="コピーして新規作成"
              >コピーして新規作成</a
            >
          </div>
        </div>
      </td>
    </tr>
EOF;
  return $job_openings_table_main;
}


function make_job_openings_table_head()
{

  $header = header_link_buttons();
  $header .= <<<EOF

  <table class="margin4 wp-list-table widefat fixed striped table-view-list posts">
  <thead>
    <tr>
      <th
        scope="col"
        id="job_position"
        class="manage-column column-job_position column-primary sorted desc"
      >
        <span>求人タイトル</span><span class="sorting-indicator"></span>
      </th>
      <th
        scope="col"
        id="job_listing_type"
        class="manage-column column-job_listing_type"
      >
        タイプ
      </th>
      <th
        scope="col"
        id="job_location"
        class="manage-column column-job_location sortable desc"
      >
        <span>社名・勤務地</span><span class="sorting-indicator"></span>
      </th>
      <th scope="col" id="job_status" class="manage-column column-job_status">
        <span class="tips" data-tip="ステータス">ステータス</span>
      </th>
      <th
        scope="col"
        id="job_posted"
        class="manage-column column-job_posted sortable desc"
      >
        <span>期限</span><span class="sorting-indicator"></span
        >
      </th>
      <!--<th
        scope="col"
        id="job_expires"
        class="manage-column column-job_expires sortable desc"
      >
      <span>期限</span><span class="sorting-indicator"></span
        >
      </th>-->
      <!--<th
        scope="col"
        id="job_listing_category"
        class="manage-column column-job_listing_category"
      >
        カテゴリー
      </th>-->
      <th scope="col" id="job_actions" class="manage-column column-job_actions">
        操作
      </th>
    </tr>
  </thead>
EOF;
  return $header;
}
