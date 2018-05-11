var TinyMceMediaModal = {
    modal: null,
    tinymce: null,

    init: function (modal, tinymce) {
        TinyMceMediaModal.modal = modal;
        TinyMceMediaModal.tinymce = tinymce;
        TinyMceMediaModal.bindForm();
    },

    bindForm: function () {
        var form = TinyMceMediaModal.modal.find('form');

        // on form submit, replace the image tag by the returned content
        form.on('submit', function () {
            $.ajax({
                url: form.attr('action'),
                method: 'post',
                data: form.serialize(),
                success: function (response) {
                    // a valid content is found, we replace the selected content in tinymce by the new one
                    if (response.content) {
                        TinyMceHelper.replaceSelected(TinyMceMediaModal.tinymce, response.content);
                        Modal.close();

                        return;
                    }
                    // the form is not valid nor submitted, display the form content
                    Modal.replace(response);
                }
            });

            return false;
        });

        // Keep the media size proportion if the check box is checked
        let keepRatioCheckbox = form.find('.keep-proportion-checkbox');
        let heightElement = $(keepRatioCheckbox.data('target-height'));
        let widthElement = $(keepRatioCheckbox.data('target-width'));
        let ratio = heightElement.val() / widthElement.val();

        heightElement.on('change', function () {
            if (keepRatioCheckbox.is(':checked')) {
                let newWidth = $(this).val() / ratio;
                widthElement.val(Math.round(newWidth));
            }
        });

        widthElement.on('change', function () {
            if (keepRatioCheckbox.is(':checked')) {
                let newHeight = $(this).val() * ratio;
                heightElement.val(Math.round(newHeight));
            }
        });
    }
};
