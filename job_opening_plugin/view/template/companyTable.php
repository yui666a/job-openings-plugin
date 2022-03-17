<?php

function make_company_table_row($data)
{
  $current_request = $_SERVER["REQUEST_URI"];
  $admin_url = esc_url(get_admin_url(''));
  $job_openings_table_main = <<<EOF
    <tr
      id="post-{$data->co_id}"
      class="iedit author-self level-0 post-{$data->co_id} type-job_listing status-publish has-post-thumbnail hentry job_listing job-type-full-time"
    >
      <td
        class="job_position column-job_position has-row-actions column-primary"
        data-colname="ポジション"
      >
        <div class="job_position">
          <a
            href="{$admin_url}post.php?post={$data->co_id}&amp;action=edit"
            class="tips job_title"
            data-tip="ID: {$data->co_id}"
            >{$data->co_name}</a
          >
          <img
            class="company_logo"
            src="{$data->co_logo}"
            alt="{$data->co_name}"
          />
        </div>
      </td>
      <td class="job_location column-job_location" data-colname="所在地">
        <a
          class="google_map_link"
          href="https://maps.google.com/maps?q={$data->co_address}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false"
          target="_blank" rel="noopener noreferrer"
          >{$data->co_address}</a
        >
      </td>
      <td class="job_created column-job_created" data-colname="作成日">
        <strong>{$data->created_at}</strong><br/>
      </td>
      <td class="job_updated column-job_updated" data-colname="最終更新日">
        <strong>{$data->updated_at}</strong>
      </td>
      <td class="job_actions column-job_actions" data-colname="操作">
        <div class="actions">
          <a
            class="button button-icon tips icon-edit"
            http://aisohitoshi.wp.xdomain.jp/company_list/
            href="{$current_request}?&action=edit&id={$data->co_id}"
            data-tip="編集"
            >編集
          </a>
          <a
            class="button button-icon tips icon-delete"
            href="{$admin_url}post.php?post={$data->co_id}&amp;action=trash&amp;_wpnonce=cf3bb74013"
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
  $admin_url = esc_url(get_admin_url(''));

  $header =header_link_buttons();
  $header .= <<<EOF

  <table class="wp-list-table widefat fixed striped table-view-list posts">
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
