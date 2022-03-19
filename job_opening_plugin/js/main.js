const position = [
  {
    id: 0,
    text: "契約社員",
  },
  {
    id: 1,
    text: "正社員",
  },
  {
    id: 2,
    text: "課長",
  },
  {
    id: 3,
    text: "エンジニア",
  },
];

$(function () {
  try {
    const select = $("#position");
    select.select2({
      placeholder: "選択してください",
      data: position,
    });
    select.val().trigger("change");
    // .on('change', (event) => {
    //   const selecions = select.select2('data').map((element) => parseInt(element.id, 10));
    // });
  } catch (e) {
    console.error(e.message);
  }
});

const locations = [
  {
    id: 0,
    text: "長岡",
  },
  {
    id: 1,
    text: "大阪",
  },
  {
    id: 2,
    text: "渋田",
  },
];

$(function () {
  try {
    const select = $("#location");
    select.select2({
      placeholder: "選択してください",
      data: locations,
    });
    select.val([0, 1]).trigger("change");
    // .on('change', (event) => {
    //   const selecions = select.select2('data').map((element) => parseInt(element.id, 10));
    // });
  } catch (e) {
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
