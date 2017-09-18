var TinyMceGalleryModal = {
    modal: null,
    tinymce: null,

    init: function (modal, tinymce) {
        this.modal = modal;
        this.tinymce = tinymce;
        this.bind();
    },

    bind: function () {
        var container = this.modal.find('.media-gallery-item');
        var target = this.modal.find('.gallery-hidden-input');
        var tinymce = this.tinymce;

        MediaGallery.init(container, {
            target: target,
            mediaLimit: 3
        });

        this.modal.find('.add-gallery-link').off().on('click', function () {
            var url = $(this).data('target');

            if (!url) {
                throw 'Invalid media gallery content url';
            }
            var selectedMedias = MediaGallery.getSelectedMedias();
            var ids = [];

            selectedMedias.each(function (index, value) {
                ids.push($(value).data('id'));
            });

            if (0 === ids.length) {
                return false;
            }
            $.get(url + '?ids=' + ids.join(','), function (data) {
                TinyMceHelper.insert(tinymce, data);
            });

            Modal.close();

            return false;
        });

        this.modal.find('.file-upload').fileupload({
            done: function () {
                MediaGallery.load($(this).data('target'));
            }
        });
    }
};
