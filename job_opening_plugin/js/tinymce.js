$(function () {
  console.log("tinymce.init begin");
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
  console.log("tinymce.init ends");
});
