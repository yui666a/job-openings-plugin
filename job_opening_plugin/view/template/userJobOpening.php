<?php

function bbb()
{
  $html = <<<EOF
  <div class="job-list-fream">
            <a href="#" class="job-list-box-wrapper">
              <div class="job-list-contents">
                <div class="job-list-box-caption">
                  <div class="job-list-img-wrapper">
                    <img
                      src="/Users/takuhirouzawa/Desktop/学生プラットフォーム/Nagaoka_worker/img/Nagaoka_worker_logo.jpeg"
                      alt=""
                      width="100%"
                      height="100%"
                    />
                  </div>
                  <div class="job-list-text-wrapper">
                    <h3 class="job-list-text-link">サンプルタイトル</h3>
                    <div class="job-list-tag-box">
                      <ul class="job-list-tag">
                        <span
                          ><li>sample</li>
                          <li>sample</li>
                          <li>sample</li>
                          <li>sample</li></span
                        >
                      </ul>
                    </div>
                    <div class="job-list-detail-box">
                      <div class="job-list-detail-link">
                        <span>…続きを見る</span>
                      </div>
                      <p class="job-list-detail-text">
                        <span>
                          サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。サンプルです。
                        </span>
                      </p>
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
  <p class="job-list-all-title">長岡ワーカーの全ての求人</p>
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
