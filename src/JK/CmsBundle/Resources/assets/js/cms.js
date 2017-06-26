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

    open: function (url) {
        var modalContent = Modal.modal.find('.modal-content');

        console.log('trace', url, modal, modalContent);

        modalContent.load(url, function () {
            Modal.modal.modal('show');
        });
    }
};



$(document).ready(function () {
    Modal.init('#modal', '.modal-trigger');
});
