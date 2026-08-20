// 素の `$(...)` は使わない。WordPress 同梱の jQuery は noConflict モードで読み込まれ、
// グローバルの `$` が定義されないため `$ is not a function` になる。
jQuery(function () {
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
