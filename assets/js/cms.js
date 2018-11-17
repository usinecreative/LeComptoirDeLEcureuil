// // Import TinyMCE
// import tinymce from 'tinymce/tinymce';
// import 'tinymce/themes/modern/theme';
//
// import 'tinymce/plugins/paste';
// import 'tinymce/plugins/paste';
// import 'tinymce/plugins/paste';
// import 'tinymce/plugins/advlist';
// import 'tinymce/plugins/autolink';
// import 'tinymce/plugins/autoresize';
// import 'tinymce/plugins/lists';
// import 'tinymce/plugins/link';
// import 'tinymce/plugins/image';
// import 'tinymce/plugins/charmap';
// import 'tinymce/plugins/print';
// import 'tinymce/plugins/preview';
// import 'tinymce/plugins/hr';
// import 'tinymce/plugins/anchor';
// import 'tinymce/plugins/pagebreak';
// import 'tinymce/plugins/searchreplace';
// import 'tinymce/plugins/wordcount';
// import 'tinymce/plugins/visualblocks';
// import 'tinymce/plugins/visualchars';
// import 'tinymce/plugins/code';
// import 'tinymce/plugins/fullscreen';
// import 'tinymce/plugins/insertdatetime';
// import 'tinymce/plugins/media';
// import 'tinymce/plugins/nonbreaking';
// import 'tinymce/plugins/save';
// import 'tinymce/plugins/table';
// import 'tinymce/plugins/directionality';
// import 'tinymce/plugins/emoticons';
// import 'tinymce/plugins/template';
// import 'tinymce/plugins/paste';
// import 'tinymce/plugins/textcolor';
// import 'tinymce/plugins/colorpicker';
// import 'tinymce/plugins/textpattern';
// import 'tinymce/plugins/imagetools';
// import $ from 'jquery';
//
// // Initialize the app
// tinymce.init({
//     selector: '#tiny',
//     plugins: ['paste', 'link']
// });

// $(document).ready(function () {
// let selector = '.tinymce-textarea';
//
// $(selector).each(function () {
//     let configuration = $(this).data('tinymce');
//     tinymce.init(configuration);
// });

// tinymce.init({
//     branding: false,
//     selector: selector,
//     plugins: plugins,
//     toolbar1: toolbar,
//     image_advtab: true,
//     relative_urls: false,
//     convert_urls : false,
//     imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
//     content_css: tinyMceContentCss,
//     body_class: 'mceForceColors container',
//     //content_style: 'body.container {background-color:#eeeae8; padding:20px 60px;}',
//     // enable default browser spell check
//     browser_spellcheck: true,
// init_instance_callback: function (editor) {
//     editor.on('dblclick', function (e) {
//         var element = $(e.target);
//         var url = '{{ url('cms.media.tinymce.edit_image') }}';
//         var queryString = '?';
//
//         $.each(e.target.attributes, function (index, attribute) {
//             queryString += 'attributes[' + attribute.name + ']=' + attribute.value;
//
//             if (index <= e.target.attributes.length - 1) {
//                 queryString += '&';
//             }
//         });
//         url += queryString;
//
//         if (element.length !== 1 || e.target.tagName !== 'IMG') {
//             return;
//         }
//
//         Modal.open(url, function (modal) {
//             TinyMceMediaModal.init(modal, tinymce);
//         });
//     })
// },
// setup: function (editor) {
//     editor.addButton('add_gallery', {
//         text: translations.addGallery,
//         icon: false,
//         onclick: function () {
//             var url = "{{ path('cms.media.add_gallery_modal') }}";
//
//             Modal.open(url, function (modal) {
//                 TinyMceGalleryModal.init(modal, tinymce);
//             });
//         }
//     });
//     editor.addButton('add_image', {
//         text: translations.addImage,
//         icon: 'image',
//         onclick: function () {
//             var url = '{{ path('cms.media.add_image_modal') }}';
//
//             Modal.open(url, function (modal) {
//                 UploadModal.init(modal, tinymce);
//             });
//         }
//     });
//     editor.on('PostRender', function () {
//         var top = 51;
//
//         // add sticky tinymce toolbar to avoid issues with long articles
//         $('.mce-toolbar')
//             .each(function () {
//                 $(this).sticky({
//                     topSpacing: top,
//                     zIndex: 900,
//                     bottomSpacing: 400
//                 });
//                 top += 35;
//                 $(this).show();
//             })
//         ;
//     });
//}
//});



//return;
// textarea unique selector
//var selector = '#{{ id }}';
// tinyMce content css path
// var tinyMceContentCss = '{{ asset(contentCss) }}';
//
// var translations = {
//     addGallery: "{{ 'cms.gallery.add_gallery' | trans | raw }}",
//     addImage: "{{ 'cms.gallery.add_image' | trans | raw }}"
// };
// var plugins = [];
// var toolbar = '{{ toolbar }}';
//

// FileUploader.init();
// });
