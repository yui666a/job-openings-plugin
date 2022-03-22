<?php

function bbb($post_id)
{
  $post = get_post($post_id, "ARRAY_A");
  $published_date = explode(" ", $post["post_date"])[0];
  $expired_date = get_post_meta($post_id, '_expired_date', true);
  // $publishing_date = (strtotime($expired_date) - strtotime($published_date)) / 86400;
  $company_id = get_post_meta($post_id, '_company_id', true);
  $recruitment_type =  get_post_meta($post_id, '_recruitment_type', true);
  $title = get_post_meta($post_id, '_title', true);
  $work_detail =  get_post_meta($post_id, '_work_detail', true);
  $application_conditions =  get_post_meta($post_id, '_application_conditions', true);
  get_post_meta($post_id, '_position', true);
  $working_conditions = get_post_meta($post_id, '_working_conditions', true);
  $occupation = get_post_meta($post_id, '_occupation', true);
  $remote_work = get_post_meta($post_id, '_remote_work', true);
  get_post_meta($post_id, '_location', true);
  $company = getCompanyById($company_id);
  $permalink = get_permalink($post_id);

  $main_text = "";
  if ($work_detail != "") {
    $main_text .= "[仕事内容] " . $work_detail;
  }
  if ($application_conditions != "") {
    $main_text .= " [募集要件] " . $application_conditions;
  }

  $main_text = str_replace("\n", " ", $main_text);
  $main_text = strip_tags($main_text);
  $main_text = mb_substr($main_text, 0, 200, 'UTF-8');

  $tags = addTags($recruitment_type, $remote_work);

  $html = <<<EOF
  <div class="job-list-fream">
    <a href="{$permalink}" class="job-list-box-wrapper">
      <div class="job-list-contents">
        <div class="job-list-box-caption">
          <div class="job-list-img-wrapper">
            <img
              src="{$company->co_logo}"
              alt=""
              width="100%"
              height="100%"
            />
          </div>
          <div class="job-list-text-wrapper">
            <div class="job-title">
              {$title}
            </div>
            <div class="job-list-tag-box">
              <ul class="job-list-tag">
                <span>
                  {$tags}
                </span>
              </ul>
            </div>
            <div class="job-list-detail-box">
              <span class="job-list-detail-text">{$main_text}</span>
              <div class="job-list-detail-link">
                <span>…続きを見る</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
EOF;
  return $html;
}

function bbb_head()
{
  $html = <<<EOF
  <div class="contents-header-wrapper">
    <div class="contents-wrapper" id="jsi-content-wrapper">
      <div class="contents-job-list-wrapper">
EOF;
  return $html;
}

function bbb_foot()
{
  $html = <<<EOF
  </div>
  </div>
</div>
EOF;
  return $html;
}
