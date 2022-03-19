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
  language: "ja",
  branding: false, // remove credit
  setup: function (editor) {
    editor.on("change", function () {
      tinymce.triggerSave();
    });
  },
  height: 300,
  // menubar: false,
  // plugins: [
  //   'advlist autolink lists link image charmap print preview anchor',
  //   'searchreplace visualblocks code fullscreen',
  //   'insertdatetime media table paste code help wordcount'
  // ],
  // toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
});