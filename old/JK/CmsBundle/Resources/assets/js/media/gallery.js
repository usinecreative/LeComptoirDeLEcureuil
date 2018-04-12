/**
 * Media gallery component for modal purpose
 */
var MediaGallery = {
    container: null,
    endpoint: null,
    target: null,
    mediaLimit: 1,

    init: function (container, options) {
        this.container = container;
        this.endpoint = container.data('target');
        this.target = options.target;
        this.mediaLimit = options.mediaLimit;
    },

    load: function () {
        // avoid to load invalid url
        if (!this.endpoint) {
            throw 'Invalid media gallery endpoint url';
        }

        this.container.load(this.endpoint, function () {
            MediaGallery.bind();
        });
    },

    bind: function () {
        this.container.find('.media-pagination a').on('click', function () {
            MediaGallery.load($(this).attr('href'));

            return false;
        });

        this.container.find('.media-list .media-item').on('click', function () {
            var medias = MediaGallery.getSelectedMedias();

            if (MediaGallery.mediaLimit === 1) {
                medias.removeClass('selected');
                $(this).toggleClass('selected');

                MediaGallery.target.val($(this).data('id'));
            } else {

                if (medias.length < MediaGallery.mediaLimit) {
                    $(this).toggleClass('selected');
                } else {
                    $(this).removeClass('selected');
                }
            }

            return false;
        });
    },

    getSelectedMedias: function () {
        return this.container.find('.media-list .media-item.selected');
    }
};
