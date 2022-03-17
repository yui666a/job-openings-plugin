<?php

function create_job_openingssss(
  $company_id,
  $recruitment_type,
  $title,
  $url,
  $position,
  $work_detail,
  $application_conditions,
  $working_conditions,
  $location,
  $remote_work,
  $occupation,
  $date_period_type,
  $trip_period,
  $trip_start,
  $trip_last
) {
  $company = getCompanyById($company_id)[0];

  $html = <<<EOF
  <div class="job-opening-card">
    <div class="header-wrapper">
      <div class="container-header">
        <h3 class="job-list-text-link">{$title}</h3>
        <div class="job-list-tag-box">
          <ul class="job-list-tag">
            <span>
              <li>(TODO: タグの内容を表示)</li>
            </span>
          </ul>
        </div>
        <a href="#" class="job-list-all-link-box">
          <p class="job-list-all-link">長岡ワーカーの全ての求人を確認する</p>
        </a>
      </div>
    </div>

    <div class="main-box">
      <div class="job-list-img-wrapper">
        <img
        src="{$company->co_logo}"
        alt="{$company->co_name}のロゴ"
        width="100%"
        height="100%"
        />
      </div>
      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">仕事内容</h1>
        </div>
        <div class="work-detail-text-box">
          <pre class="work-detail-text">{$work_detail}</pre>
        </div>
        <div style="border-collapse: collapse" border-color="EEE">
          <div class="assignment">
            <div class="assignment-item-label">職種 / 募集ポジション</div>
            <div class="assignment-item-value">
              <pre>{$occupation}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">雇用形態</div>
            <div class="assignment-item-value">
              <pre>{$working_conditions}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">給与</div>
            <div class="assignment-item-value">
              <pre>(TODO: 給与の情報を表示)</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">勤務地</div>
            <div class="assignment-item-value">
            <pre><a href="https://maps.google.com/maps?q={$company->co_address}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false" class="google-map-address"
            >〒{$company->co_zip_code}  {$company->co_address}
          </a></pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">就業時間</div>
            <div class="assignment-item-value">
              <pre>{$company->co_office_hours}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">休日</div>
            <div class="assignment-item-value">
              <pre>{$company->co_day_off}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">制度・福利厚生</div>
            <div class="assignment-item-value">
              <pre>{$company->co_employee_benefits}</pre>
            </div>
          </div>
          <div class="assignment">
            <div class="assignment-item-label">勤務地の所在地</div>
            <div class="assignment-item-value">
              <pre><a href="https://maps.google.com/maps?q={$company->co_address}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false" class="google-map-address"
              >〒{$company->co_zip_code}  {$company->co_address}
            </a></pre>
              <!--iframe要素はgoogle mapのHTMLコピーで260px × 260pxのカスタムサイズで貼り付けています-->
              <!-- <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3242.7694570079743!2d139.7145596152575!3d35.6334095802055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188b1ea8e63243%3A0x12338cc78949be38!2z44CSMTQxLTAwMjEg5p2x5Lqs6YO95ZOB5bed5Yy65LiK5aSn5bSO77yT5LiB55uu77yR4oiS77yRIOebrum7kuOCu-ODs-ODiOODqeODq-OCueOCr-OCqOOCog!5e0!3m2!1sja!2sjp!4v1647010839521!5m2!1sja!2sjp"
              width="260"
              height="260"
              style="border: 0"
              allowfullscreen=""
              loading="lazy"
            ></iframe> -->
            </div>
          </div>
        </div>
      </div>

      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">募集要項</h1>
        </div>
        <div class="work-detail-text-box">
          <pre class="work-detail-text">{$application_conditions}</pre>
        </div>
      </div>

      <div class="job-list-work-detail">
        <div class="work-detial-header">
          <h1 class="work-detail-header-title">会社概要</h1>
        </div>
        <div class="work-detail-text-box">
          <pre class="work-detail-text">{$company->co_pr_point}</pre>
        </div>
      </div>

      <div class="assignment-table-box">
        <div class="company-information-table-box">
          <div style="border-collapse: collapse" border-color="EEE">
            <div class="assignment">
              <div class="assignment-item-label">会社名</div>
              <div class="assignment-item-value">
                <pre>{$company->co_name}</pre>
              </div>
            </div>

            <!--
            <div class="assignment">
              <div class="assignment-item-label">グループについて</div>
              <div class="assignment-item-value">
                <pre>(TODO: グループについての情報を表示)</pre>
              </div>
            </div>

            <div class="assignment">
              <div class="assignment-item-label">事業会社一覧</div>
              <div class="assignment-item-value">
                <pre>(TODO: 事業会社一覧の情報を表示)</pre>
              </div>
            </div>
            -->

            <div class="assignment">
              <div class="assignment-item-label">本社所在地</div>
              <div class="assignment-item-value">
                <pre><a href="https://maps.google.com/maps?q={$company->co_address}&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false" class="google-map-address"
                >〒{$company->co_zip_code}  {$company->co_address}</a
              ></pre>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="btn-application-under">
        <a href="#" class="btn-application-under-text">応募画面に進む</a>
      </div>
    </div>
  </div>
EOF;
  return $html;
}
