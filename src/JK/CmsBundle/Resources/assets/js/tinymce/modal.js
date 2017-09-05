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
        // keep the media size proportion if the check box is checked
        form.find('.keep-proportion-checkbox:checked').each(function () {
            var heightElement = $($(this).data('target-height'));
            var widthElement = $($(this).data('target-width'));
            var ratio = heightElement.val() / widthElement.val();

            heightElement.on('change', function () {
                var newWidth = $(this).val() / ratio;
                widthElement.val(Math.round(newWidth));
            });
            widthElement.on('change', function () {
                var newHeight = $(this).val() * ratio;
                heightElement.val(Math.round(newHeight));
            });
        });
    }
};
