const position = [
  { id: 0, text: "契約社員" },
  { id: 1, text: "正社員" },
  { id: 2, text: "課長" },
  { id: 3, text: "エンジニア" },
];

$(function () {
  const select = $("#position");
  select.select2({
    placeholder: "選択してください",
    data: position,
  });
  select.val().trigger("change");
  // .on('change', (event) => {
  //   const selecions = select.select2('data').map((element) => parseInt(element.id, 10));
  // });
});

const locations = [
  { id: 0, text: "長岡" },
  { id: 1, text: "大阪" },
  { id: 2, text: "渋田" },
];

$(function () {
  const select = $("#location");
  select.select2({
    placeholder: "選択してください",
    data: locations,
  });
  select.val([0, 1]).trigger("change");
  // .on('change', (event) => {
  //   const selecions = select.select2('data').map((element) => parseInt(element.id, 10));
  // });
});

