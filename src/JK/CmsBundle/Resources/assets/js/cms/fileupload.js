$(document).on('ready', function () {
    var fileupload = $('.cms-fileupload');
    var removeMediaLink = $('.remove-media');

    fileupload.fileupload({
        done: function (e, data) {
            // ajax response
            var result = JSON.parse(data.result);
            // file upload
            var formInput = $(this).parents('.input-group');
            // target media id hidden field
            var targetMediaIdSelector = $(this).data('target');

            // add the new media to the template image src attribute
            formInput.find('.media-target').attr('src', result.mediaUrl);
            // add the new media id to the target media id field
            $(targetMediaIdSelector).val(result.mediaId);
            // display the remove media link
            removeMediaLink.show();
        }
    });
    removeMediaLink.on('click', function () {
        // file upload
        var formInput = $(this).parents('.input-group');
        // target media id hidden field
        var targetMediaIdSelector = $(this).data('target');

        // empty the image tag src
        formInput.find('.media-target').attr('src', '');
        // empty the hidden id field
        $(targetMediaIdSelector).val('');
        // hide the remove media link
        $(this).hide();

        return false;
    });
});
