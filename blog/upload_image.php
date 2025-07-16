tinymce.init({
selector: '#contenu',
plugins: [
'anchor autolink charmap codesample emoticons image link lists media searchreplace',
'table visualblocks wordcount checklist mediaembed casechange formatpainter pageembed',
'a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage',
'advtemplate mentions tinycomments tableofcontents footnotes mergetags autocorrect',
'typography inlinecss markdown importword exportword exportpdf',
'paste' // ← ajoute le plugin paste
],
toolbar:
'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
'link image media table mergetags | addcomment showcomments | ' +
'spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | ' +
'emoticons charmap | removeformat',
paste_data_images: true, // ← active le drag-drop en base64
automatic_uploads: true,
images_upload_url: 'blog/upload_image.php',
images_upload_credentials: true,
image_title: true,
file_picker_types: 'image',
/* (facultatif) pour un contrôle JS direct :
images_upload_handler: function (blobInfo, success, failure) {
// blobInfo.blob() → contient l’image
// tu peux la renvoyer vers ton upload via fetch/XHR
// appel success(url) ou failure(msg)
}
*/
});