var MediaHelper = {
    getMediaContent: function (ids) {
        
    }
};

var MediaGallery = {
    element: null,
    options: {},

    init: function (options) {
        var defaults = {
            selector: '.media-list'
        };
        this.options = defaults.concat(options);
        this.element = $(this.options.selector);

        // select the media on click
        this.element
            .find('.media .media-link')
            .on('click', function () {
                $(this).toggleClass('selected');

                return false
            })
        ;
        $('#add-gallery-btn').on('click', function () {
            var selectedMedias = galleryModal.find('.media a.selected');

            if (selectedMedias.length === 0) {
                return;
            }
            var ids = [];

            selectedMedias.each(function (index, value) {
                ids.push($(value).data('id'));
            });
            var route = routes.galleryContent + '?ids=' + ids.join(',');

            $.get(route, function (data) {
                tinymce.activeEditor.execCommand('mceInsertContent', false, data);
                galleryModal.modal('hide');
            });
        });
    },

    getSelectedMediaIds: function () {
        var mediaGallery = $(this.selector);
        var medias = mediaGallery.find('.media a.selected');
        var ids = [];

        medias.each(function (index, value) {
            ids.push($(value).data('id'));
        });

        return ids;
    }
};
