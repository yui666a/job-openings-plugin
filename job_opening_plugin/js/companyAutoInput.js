$(function () {
  //セレクトボックスが切り替わったら発動
  $("[name=company_id]").change(function () {
    var companies_data = JSON.parse($("[name=companies_data]").val());

    //選択したvalue値を変数に格納
    var id = $("[name=company_id]").val();
    var company_data = companies_data.filter(function (item, index) {
      if (item.co_id == id) return true;
    });

    //選択したvalue値をp要素に出力
    $("[name=company_name]").val(company_data[0].co_name);
    $("[name=company_sector]").val(company_data[0].co_sector);
    $("[name=company_url]").val(company_data[0].co_url);
    $("[name=company_pr]").val(company_data[0].co_pr_point);
    $("[name=company_zipcode]").val(company_data[0].co_zip_code);
    $("[name=company_address]").val(company_data[0].co_address);
    $("[name=company_achievement]").val(company_data[0].co_achievement);
    $("[name=company_office_hour]").val(company_data[0].co_office_hours);
    $("[name=company_benefits]").val(company_data[0].co_employee_benefits);
    $("[name=company_day_off]").val(company_data[0].co_day_off);
  });
});