var frame;
;( function ($) {

    "use strict";

    $( document ).ready( function () {

        var imageUrl = $( "#alt-logo-url" ).val();
        if ( imageUrl ) {
            $( "#alt-logo-container" ).html(`<img src='${imageUrl}' />`); }

        $( "#upload_image" ).on( "click" , function () {

            if ( frame ) {
                frame.open();
                return false; }

            frame = wp.media({
                title: alt.sl,
                button: {
                    text: alt.il
                },
                multiple: false
            } );

            frame.on( 'select' , function () {
                var attachment = frame.state().get( 'selection' ).first().toJSON();
                $( "#alt-logo-url" ).val( attachment.sizes.full.url );
                $( "#alt-logo-container" ).html( `<img src='${attachment.sizes.full.url}' />` );
            } );

            frame.open();
            return false;
        } );
        
    } );

} )( jQuery );