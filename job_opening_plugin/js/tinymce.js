$(function () {
  tinymce.init({
    selector: "textarea", //全てのtextareaに適応
    forced_root_block: "div", //デフォルトの要素を<p>から<div>に変更
    language: "ja", // 言語 日本語
    setup: function (editor) {
      editor.on("change", function () {
        tinymce.triggerSave();
      });
    },
  });
});
