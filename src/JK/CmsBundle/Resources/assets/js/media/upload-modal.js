var UploadModal = {
    modal: null,
    tinymce: null,

    init: function (modal, tinymce) {
        UploadModal.tinymce = tinymce;
        UploadModal.modal = modal;

        UploadModal.bindForm();
        FileUploader.init();
    },

    /**
     * Bind the media upload modal form.
     */
    bindForm: function () {
        var form = UploadModal.modal.find('form');

        UploadModalForm.init(form);
    }
};

var UploadModalForm = {
    form: null,

    init: function (form) {
        UploadModalForm.form = form;
        UploadModalForm.bind();
    },

    bind: function () {
        // Bind media radio buttons to display and hide form parts according to the selected value.
        var choices = UploadModalForm.form.find('.media-choice');

        choices.on('change', function () {
            displayFormParts();
        });
        displayFormParts();
        bindForm();

        /**
         * Display form parts according to the selected value.
         */
        function displayFormParts () {
            var value = UploadModalForm.getSelectedChoiceValue();

            if (value === 'upload_from_url') {
                $('.media-choice-item').addClass('hidden');
                $('.upload_from_url').parents('.media-choice-item').removeClass('hidden');
            } else if (value === 'upload_from_computer') {
                $('.media-choice-item').addClass('hidden');
                $('.upload_from_computer').parents('.media-choice-item').removeClass('hidden');
            } else if (value === 'choose_from_collection') {
                $('.media-choice-item').addClass('hidden');
                $('.media-gallery-item').removeClass('hidden');

                UploadModalForm.displayMediaGallery();
            }
        }

        /**
         * Bind form submission.
         */
        function bindForm () {
            UploadModalForm.form.off().on('submit', function () {
                var url = UploadModalForm.form.attr('action');

                $.ajax({
                    url: url,
                    method: 'post',
                    data: UploadModalForm.form.serialize(),
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

                            return;
                        }

                        if (status === 'nocontent') {
                            Modal.close();

                            return;
                        }
                        // there is an error in the form submission, we must re-display the form to show the error
                        // messages
                        Modal.replace(response);

                        UploadModalForm.init(Modal.modal.find('form'));
                        //modal.find('.modal-content').html(response);
                        //bindForm(modal.find('form'));
                        //UploadModal.init();
                    }
                });

                return false;
            });
        }
    },

    getSelectedChoiceValue: function () {
        return UploadModalForm.form.find('.media-choice').find(':checked').val();
    },

    /**
     * Display the media gallery
     */
    displayMediaGallery: function () {
        var container = UploadModal.modal.find('.media-gallery-item');
        var target = UploadModal.modal.find('.gallery-hidden-input');

        MediaGallery.init(container, {
            target: target,
            mediaLimit: 1
        });
        MediaGallery.load();
    }
};
