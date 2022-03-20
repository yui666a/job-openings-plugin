$(function () {
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