<?php

function make_company_table_row($data)
{
  $admin_url = esc_url(get_admin_url(''));
  $job_openings_table_main = <<<EOF
    <tr
      id="post-{$data->co_id}"
      class="iedit author-self level-0 post-{$data->co_id} type-job_listing status-publish has-post-thumbnail hentry job_listing job-type-full-time"
    >
      <th scope="row" class="check-column">
        <label class="screen-reader-text" for="cb-select-{$data->co_id}">{$data->co_name}
        </label>
        <input id="cb-select-{$data->co_id}" type="checkbox" name="post[]" value="{$data->co_id}" />
        <div class="locked-indicator">
          <span class="locked-indicator-icon" aria-hidden="true"></span>
          <span class="screen-reader-text">
            “{$data->co_name}” はロックされています
          </span>
        </div>
      </th>
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
            src="/wp-content/uploads/job-manager-uploads/company_logo/2022/02/SAIN_logo-150x150.png"
            alt="{$data->co_name}"
          />
        </div>
        <button type="button" class="toggle-row">
          <span class="screen-reader-text">詳細を追加表示</span>
        </button>
      </td>
      <td class="job_location column-job_location" data-colname="所在地">
        <a
          class="google_map_link"
          href="https://maps.google.com/maps?q={$data->co_address}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false"
          target="_blank" rel="noopener noreferrer"
          >{$data->co_address}</a
        >
      </td>
      <td class="job_status column-job_status" data-colname="ステータス">
      {$data->status}
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
            href="{$admin_url}post.php?post={$data->co_id}&amp;action=edit"
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

  $header = <<<EOF
  <table class="wp-list-table widefat fixed striped table-view-list posts">
  <thead>
    <tr>
      <td id="cb" class="manage-column column-cb check-column">
        <label class="screen-reader-text" for="cb-select-all-1"
          >すべて選択</label
        ><input id="cb-select-all-1" type="checkbox" />
      </td>
      <th
        scope="col"
        id="job_position"
        class="manage-column column-job_position column-primary sorted desc"
      >
        <a
          href="{$admin_url}edit.php?post_type=job_listing&amp;orderby=title&amp;order=asc"
          ><span>ポジション</span><span class="sorting-indicator"></span
        ></a>
      </th>
      <th
        scope="col"
        id="job_location"
        class="manage-column column-job_location sortable desc"
      >
        <a
          href="{$admin_url}edit.php?post_type=job_listing&amp;orderby=job_location&amp;order=asc"
          ><span>所在地</span><span class="sorting-indicator"></span
        ></a>
      </th>
      <th scope="col" id="job_status" class="manage-column column-job_status">
        <span class="tips" data-tip="ステータス">ステータス</span>
      </th>
      <th
        scope="col"
        id="job_created"
        class="manage-column column-job_created sortable desc"
      >
        <a
          href="{$admin_url}edit.php?post_type=job_listing&amp;orderby=job_expires&amp;order=asc"
          ><span>作成日</span><span class="sorting-indicator"></span
        ></a>
      </th>
      <th
        scope="col"
        id="job_created"
        class="manage-column column-job_created sortable desc"
      >
        <a
          href="{$admin_url}edit.php?post_type=job_listing&amp;orderby=job_expires&amp;order=asc"
          ><span>最終更新日</span><span class="sorting-indicator"></span
        ></a>
      </th>
      <th scope="col" id="job_actions" class="manage-column column-job_actions">
        操作
      </th>
    </tr>
  </thead>
EOF;
  return $header;
}
