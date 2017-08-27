var Modal = {
    modal: null,

    init: function (modalSelector, triggerSelector) {
        this.modal = $(modalSelector);

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

    close: function () {
        Modal.modal.modal('close');
    }
};
