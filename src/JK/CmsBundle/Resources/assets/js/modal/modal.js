var Modal = {
    modal: null,

    init: function (modalSelector, triggerSelector) {
        Modal.modal = $(modalSelector);

        $(triggerSelector).on('click', function () {
            var url = $(this).data('target');

            if (!url) {
                return false;
            }
            Modal.open(url);

            return false;
        });
    },

    open: function (url, bindingCallback) {
        var modalContent = Modal.modal.find('.modal-content');

        modalContent.load(url, function () {

            if (bindingCallback) {
                bindingCallback(Modal.modal);
            }
            Modal.modal.modal('show');
        });
    },

    replace: function (content) {
        Modal.modal.find('.modal-content').html(content);
    },

    close: function () {
        Modal.replace('');
        Modal.modal.modal('hide');
    }
};
