jQuery(function($) {
    var imageFrame;

    $(document).on('click', '.newar-image-upload', function(e) {
        e.preventDefault();
        var button = $(this);
        var hiddenInput = button.siblings('.newar-image-id');

        if (imageFrame) {
            imageFrame.open();
            return;
        }

        imageFrame = wp.media({
            title: 'Select or Upload Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        imageFrame.on('select', function() {
            var attachment = imageFrame.state().get('selection').first().toJSON();
            hiddenInput.val(attachment.id);
            button.siblings('.newar-image-remove').show();
            button.siblings('img').attr('src', attachment.sizes.medium.url || attachment.url).show();
        });

        imageFrame.open();
    });

    $(document).on('click', '.newar-image-remove', function() {
        var button = $(this);
        button.siblings('.newar-image-id').val('');
        button.siblings('img').hide().attr('src', '');
        button.hide();
    });

    $(document).on('click', '.newar-gallery-remove', function() {
        var id = $(this).data('id');
        var container = $(this).closest('li');
        container.fadeOut(200, function() {
            $(this).remove();
        });
    });
});