<?php

function get_occupation_ja($key)
{
  $occupations = [
    "sales_associate" => "営業",
    "clerk" => "事務・管理",
    "marketer" => "企画・マーケティング・経営・管理職",
    "service" => "サービス・販売・外食",
    "web" => "Web・インターネット・ゲーム",
    "creative" => "クリエイティブ（メディア・アパレル・デザイン）",
    "expert" => "専門職（コンサルタント・士業・金融・不動産）",
    "it_engineer" => "ITエンジニア（システム開発・SE・インフラ）",
    "engineer" => "エンジニア（機械・電気・電子・半導体・制御）",
    "chemical_engineer" => "素材・化学・食品・医薬品技術職",
    "civil_engineer" => "建築・土木技術職",
    "transporter" => "技能工・設備・交通・運輸",
    "medical_welfare" => "医療・福祉・介護",
    "public_servant" => "教育・保育・公務員・農林水産・その他",
  ];
  return $occupations[$key];
}
