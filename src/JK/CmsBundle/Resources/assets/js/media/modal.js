var MediaModal = {
    init: function () {
        bindRadioButtons();

        // bind media radio buttons to display and hide form parts according to the selected value
        function bindRadioButtons() {
            var choices = $('.media-choice');

            choices.on('change', function () {
                displayFormParts($(this).find(':checked').val());
            });
            displayFormParts(choices.find(':checked').val());

            // display form parts according to the selected value
            function displayFormParts(value) {
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
            }
        }
    }
};
