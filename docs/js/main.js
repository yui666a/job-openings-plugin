// 職種
const occupations = [
  {
    id: "sales_associate",
    text: "営業",
  },
  {
    id: "clerk",
    text: "事務・管理",
  },
  {
    id: "marketer",
    text: "企画・マーケティング・経営・管理職",
  },
  {
    id: "service",
    text: "サービス・販売・外食",
  },
  {
    id: "web",
    text: "Web・インターネット・ゲーム",
  },
  {
    id: "creative",
    text: "クリエイティブ（メディア・アパレル・デザイン）",
  },
  {
    id: "expert",
    text: "専門職（コンサルタント・士業・金融・不動産）",
  },
  {
    id: "it_engineer",
    text: "ITエンジニア（システム開発・SE・インフラ）",
  },
  {
    id: "engineer",
    text: "エンジニア（機械・電気・電子・半導体・制御）",
  },
  {
    id: "chemical_engineer",
    text: "素材・化学・食品・医薬品技術職",
  },
  {
    id: "civil_engineer",
    text: "建築・土木技術職",
  },
  {
    id: "transporter",
    text: "技能工・設備・交通・運輸",
  },
  {
    id: "medical_welfare",
    text: "医療・福祉・介護",
  },
  {
    id: "public_servant",
    text: "教育・保育・公務員・農林水産・その他",
  },
];

$(document).ready(function () {
  try {
    $("#occupation").select2({
      multiple: "multiple",
      maximumSelectionLength: 3,
      placeholder: "最大3つまで選択いただけます",
      language: {
        maximumSelected: (args) => args.maximum + "つ以下にしてください",
      },
      data: occupations,
    });
    // phpから選択されている職種を読み込む
    var selected_occupations = JSON.parse(
      $("[name=selected_occupations]").val()
    );
    $("#occupation").val(selected_occupations).trigger("change");
  } catch (e) {
    console.error("エラー");
    console.error(e.message);
  }
});

// 企業の情報入力画面で企業ロゴをプレビュー表示する
$("#company_logo").on("change", function (e) {
  var reader = new FileReader();
  reader.onload = function (e) {
    $("#logo_preview").attr("src", e.target.result);
  };
  reader.readAsDataURL(e.target.files[0]);
});
