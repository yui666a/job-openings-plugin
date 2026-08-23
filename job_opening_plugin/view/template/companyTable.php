<?php

function make_company_table_row($data)
{
  $coTable_page = home_url("/" . get_option("sac_company_list"));
  // 削除は GET だけで発火するため、リンク自体に nonce を持たせる
  // wp_nonce_url() は内部で esc_html() を通すため、ここで重ねてエスケープしない
  $remove_url = wp_nonce_url($coTable_page . "?&action=remove&id=" . $data->co_id, 'job_opening_remove_company_' . $data->co_id, 'ticket');

  // ヒアドキュメント内では関数を呼べないため、埋め込む前にエスケープした変数を用意する
  $e_coTable_page = esc_url($coTable_page);
  $e_co_id = esc_attr($data->co_id);
  $e_co_name = esc_html($data->co_name);
  $e_co_name_attr = esc_attr($data->co_name);
  $e_co_logo = esc_url($data->co_logo);
  $e_co_address = esc_html($data->co_address);
  $e_map_url = esc_url('https://maps.google.com/maps?q=' . $data->co_address . '&zoom=14&size=512x512&maptype=roadmap&sensor=false');
  $e_created_at = esc_html($data->created_at);
  $e_updated_at = esc_html($data->updated_at);
  $job_openings_table_main = <<<EOF
    <tr
      id="post-{$e_co_id}"
      class="iedit author-self level-0 post-{$e_co_id} type-job_listing status-publish has-post-thumbnail hentry job_listing job-type-full-time"
    >
      <td
        class="job_position column-job_position has-row-actions column-primary"
        data-colname="ポジション"
      >
        <div class="job_position">
          <a
            href="{$e_coTable_page}?&action=edit&id={$e_co_id}"
            data-tip="ID: {$e_co_id}"
            >
            {$e_co_name}</a>
            <br/>
          <img
            class="company_logo"
            src="{$e_co_logo}"
            alt="{$e_co_name_attr}"
          />
        </div>
      </td>
      <td class="job_location column-job_location" data-colname="所在地">
        <a
          class="google_map_link"
          href="{$e_map_url}"
          target="_blank" rel="noopener noreferrer"
          >{$e_co_address}</a
        >
      </td>
      <td class="job_created column-job_created" data-colname="作成日">
        <strong>{$e_created_at}</strong><br/>
      </td>
      <td class="job_updated column-job_updated" data-colname="最終更新日">
        <strong>{$e_updated_at}</strong>
      </td>
      <td class="job_actions column-job_actions" data-colname="操作">
        <div class="actions">
          <a
            class="button button-icon tips icon-edit"
            href="{$e_coTable_page}?&action=edit&id={$e_co_id}"
            data-tip="編集"
            >編集
          </a>
          <a
            class="button button-icon tips icon-delete"
            href="{$remove_url}"
            data-tip="削除"
            >削除
          </a>
        </div>
      </td>
    </tr>
EOF;
  return $job_openings_table_main;
}


function make_company_table_head()
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
        <span>ポジション</span>
      </th>
      <th
        scope="col"
        id="job_location"
        class="manage-column column-job_location sortable desc"
      >
        <span>所在地</span><span class="sorting-indicator"></span
        >
      </th>
      <th
        scope="col"
        id="job_created"
        class="manage-column column-job_created sortable desc"
      >
        <span>作成日</span><span class="sorting-indicator"></span
        >
      </th>
      <th
        scope="col"
        id="job_created"
        class="manage-column column-job_created sortable desc"
      >
        <span>最終更新日</span><span class="sorting-indicator"></span
        >
      </th>
      <th scope="col" id="job_actions" class="manage-column column-job_actions">
        操作
      </th>
    </tr>
  </thead>
EOF;
  return $header;
}
