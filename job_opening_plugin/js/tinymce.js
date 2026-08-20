// WordPress 同梱の jQuery は noConflict モードで読み込まれ、グローバルの `$` が定義されない。
// 素の `$(...)` のままでは `$ is not a function` になるため、`$` を引数で受け取る。
jQuery(function ($) {
  tinymce.init({
    selector: "textarea.rich", // <textarea class="rich"...></textarea>
    forced_root_block: "div", // modify default tag <p> -> <div>
    language: "ja",
    branding: false, // remove credit
    setup: function (editor) {
      editor.on("change", function () {
        tinymce.triggerSave();
      });
    },
  });
});

jQuery(function ($) {
  $('textarea.rich').tinymce({
    selector: "textarea.rich", // <textarea class="rich"...></textarea>
    forced_root_block: "div", // modify default tag <p> -> <div>
    content_style: "body {font-size: 14pt;}",
    language: "ja",
    branding: false, // remove credit
    setup: function (editor) {
      editor.on("change", function () {
        tinymce.triggerSave();
      });
    },
    height: 300,
  });
});