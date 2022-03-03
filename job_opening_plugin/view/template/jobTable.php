<?php

function make_job_openings_table_row($post_id, $title, $author, $post_date, $job_expires, $job_location, $status_icon)
{
  $admin_url = esc_url(get_admin_url(''));
  $job_openings_table_main = <<<EOF
    <tr
      id="post-{$post_id}"
      class="iedit author-self level-0 post-{$post_id} type-job_listing status-publish has-post-thumbnail hentry job_listing job-type-full-time"
    >
      <th scope="row" class="check-column">
        <label class="screen-reader-text" for="cb-select-{$post_id}">{$title}
        </label>
        <input id="cb-select-{$post_id}" type="checkbox" name="post[]" value="{$post_id}" />
        <div class="locked-indicator">
          <span class="locked-indicator-icon" aria-hidden="true"></span>
          <span class="screen-reader-text">
            “{$title}” はロックされています
          </span>
        </div>
      </th>
      <td
        class="job_position column-job_position has-row-actions column-primary"
        data-colname="求人タイトル"
      >
        <div class="job_position">
          <a
            href="{$admin_url}post.php?post={$post_id}&amp;action=edit"
            class="tips job_title"
            data-tip="ID: {$post_id}"
            >{$title}</a
          >
          <img
            class="company_logo"
            src="/wp-content/uploads/job-manager-uploads/company_logo/2022/02/SAIN_logo-150x150.png"
            alt="{$author}"
          />
        </div>
        <button type="button" class="toggle-row">
          <span class="screen-reader-text">詳細を追加表示</span>
        </button>
      </td>
      <td
        class="job_listing_type column-job_listing_type"
        data-colname="タイプ"
      >
        <span class="job-type full-time">Full Time</span>
      </td>
      <td class="job_location column-job_location" data-colname="社名・勤務地">
      <div class="company">
            <span class="tips" data-tip="asdf"
              ><a href="https://yui666a.github.io/home/pc.html(TODO)"
                >{$author}</a
              ></span
            >
          </div>
        <a
          class="google_map_link"
          href="https://maps.google.com/maps?q={$job_location}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false"
          >{$job_location}</a
        >
      </td>
      <td class="job_status column-job_status" data-colname="ステータス">
        {$status_icon}
      </td>
      <td class="job_posted column-job_posted" data-colname="作成日">
        <strong>{$post_date}</strong
        ><span
          >投稿者:
          <a
            href="/wp-admin/edit.php?post_type=job_listing&amp;orderby=title&amp;order=desc&amp;author=1"
            >TODO: yui666a</a
          ></span
        >
      </td>
      <td class="job_expires column-job_expires" data-colname="期限">
        <strong>{$job_expires}</strong>
      </td>
      <td
        class="job_listing_category column-job_listing_category"
        data-colname="カテゴリー"
      >
        <span class="na">–</span>
      </td>
      <td class="featured_job column-featured_job" data-colname="注目 ?">–</td>
      <td class="filled column-filled" data-colname="採用済み ?">–</td>
      <td class="job_actions column-job_actions" data-colname="操作">
        <div class="actions">
          <a
            class="button button-icon tips icon-view"
            href="http://aisohitoshi.wp.xdomain.jp/job/%e3%82%a2%e3%83%b3%e3%82%bf%e3%83%83%e3%83%81%e3%83%a3%e3%83%96%e3%83%ab-%e5%9c%b0%e7%90%83-full-time-%e3%82%b7%e3%83%a3%e3%83%83%e3%83%81%e3%83%a7%e3%81%95%e3%82%93/(TODO)"
            data-tip="表示"
            >表示</a
          ><a
            class="button button-icon tips icon-edit"
            href="{$admin_url}post.php?post={$post_id}&amp;action=edit"
            data-tip="編集"
            >編集</a
          ><a
            class="button button-icon tips icon-delete"
            href="{$admin_url}post.php?post={$post_id}&amp;action=trash&amp;_wpnonce=cf3bb74013"
            data-tip="削除"
            >削除</a
          >
        </div>
      </td>
    </tr>
EOF;
  return $job_openings_table_main;
}


function make_job_openings_table_head()
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
          ><span>求人タイトル</span><span class="sorting-indicator"></span
        ></a>
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
        <a
          href="{$admin_url}edit.php?post_type=job_listing&amp;orderby=job_location&amp;order=asc"
          ><span>社名・勤務地</span><span class="sorting-indicator"></span
        ></a>
      </th>
      <th scope="col" id="job_status" class="manage-column column-job_status">
        <span class="tips" data-tip="ステータス">ステータス</span>
      </th>
      <th
        scope="col"
        id="job_posted"
        class="manage-column column-job_posted sortable desc"
      >
        <a
          href="{$admin_url}edit.php?post_type=job_listing&amp;orderby=date&amp;order=asc"
          ><span>作成日</span><span class="sorting-indicator"></span
        ></a>
      </th>
      <th
        scope="col"
        id="job_expires"
        class="manage-column column-job_expires sortable desc"
      >
        <a
          href="{$admin_url}edit.php?post_type=job_listing&amp;orderby=job_expires&amp;order=asc"
          ><span>期限</span><span class="sorting-indicator"></span
        ></a>
      </th>
      <th
        scope="col"
        id="job_listing_category"
        class="manage-column column-job_listing_category"
      >
        カテゴリー
      </th>
      <th
        scope="col"
        id="featured_job"
        class="manage-column column-featured_job"
      >
        <span class="tips" data-tip="注目 ?">注目 ?</span>
      </th>
      <th scope="col" id="filled" class="manage-column column-filled">
        <span class="tips" data-tip="採用済み ?">採用済み ?</span>
      </th>
      <th scope="col" id="job_actions" class="manage-column column-job_actions">
        操作
      </th>
    </tr>
  </thead>
EOF;
  return $header;
}
