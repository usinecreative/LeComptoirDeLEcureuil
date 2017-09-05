var UploadModal = {
    modal: null,
    tinymce: null,

    init: function (modal, tinymce) {
        UploadModal.tinymce = tinymce;
        UploadModal.modal = modal;
        UploadModal.bindRadioButtons();
        UploadModal.bindForm();
        FileUploader.init();
    },

    /**
     * Bind media radio buttons to display and hide form parts according to the selected value.
     */
    bindRadioButtons: function () {
        var choices = $('.media-choice');

        choices.on('change', function () {
            UploadModal.displayFormParts($(this).find(':checked').val());
        });
        UploadModal.displayFormParts(choices.find(':checked').val());
    },

    /**
     * Display form parts according to the selected value.
     *
     * @param value
     */
    displayFormParts: function (value) {
        if (value === 'upload_from_url') {
            $('.media-choice-item').addClass('hidden');
            $('.upload_from_url').parents('.media-choice-item').removeClass('hidden');
        } else if (value === 'upload_from_computer') {
            $('.media-choice-item').addClass('hidden');
            $('.upload_from_computer').parents('.media-choice-item').removeClass('hidden');
        } else if (value === 'choose_from_collection') {
            $('.media-choice-item').addClass('hidden');
            $('.media-gallery-item').removeClass('hidden');
        }
    },

    // bind the media modal form
    bindForm: function (modal) {
        var form = UploadModal.modal.find('form');

        form.off().on('submit', function () {
            var url = form.attr('action');

            $.ajax({
                url: url,
                method: 'post',
                data: form.serialize(),
                success: function (response, status) {

                    if (response.media && response.media.id) {
                        var elementId = 'assets-' + Math.round(Math.random()) + '-' + Math.round(Math.random());
                        // add br to allow the user to add some content after the image if it is the last tag
                        // in tinymce content and when it is aligned to left
                        var content = '<img id="' + elementId + '" src="' + response.media.path + '" class="article-image" /><br/><br/>';

                        // insert the new image tag and trigger the double click to display the media modal
                        TinyMceHelper.insert(UploadModal.tinymce, content);
                        TinyMceHelper.select(UploadModal.tinymce, elementId);
                        Modal.close();

                        TinyMceHelper.trigger(UploadModal.tinymce, elementId);

                        return;
                    }

                    if (status === 'nocontent') {
                        Modal.close();

                        return;
                    }
                    //console.log(response, status);
                    modal.find('.modal-content').html(response);
                    bindForm(modal.find('form'));
                    UploadModal.init();
                }
            });

            return false;
        });
    }
};
