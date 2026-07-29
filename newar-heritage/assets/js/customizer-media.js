( function ( $ ) {
    var api = wp.customize;

    function initMediaControl( controlId ) {
        var control = api.control( controlId );
        if ( ! control ) {
            return;
        }

        var frame;

        control.container.find( '.upload-button' ).on( 'click', function ( event ) {
            event.preventDefault();

            if ( frame ) {
                frame.open();
                return;
            }

            frame = wp.media( {
                title: control.params.label,
                library: {
                    type: 'image',
                },
                multiple: false,
            } );

            frame.on( 'select', function () {
                var attachment = frame.state().get( 'selection' ).first().toJSON();

                api.instance( controlId ).set( attachment.id );
                control.container.find( '.thumbnail img' ).attr( 'src', attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url );
                control.container.find( '.upload-button' ).hide();
                control.container.find( '.remove-button' ).show();
            } );

            frame.open();
        } );

        control.container.find( '.remove-button' ).on( 'click', function ( event ) {
            event.preventDefault();
            api.instance( controlId ).set( '' );
            control.container.find( '.thumbnail img' ).attr( 'src', '' );
            control.container.find( '.upload-button' ).show();
            control.container.find( '.remove-button' ).hide();
        } );
    }

    api.bind( 'ready', function () {
        initMediaControl( 'newar_heritage_hero_image' );

        for ( var i = 1; i <= 8; i++ ) {
            initMediaControl( 'newar_heritage_gallery_image_' + i );
        }
    } );
} )( jQuery );
