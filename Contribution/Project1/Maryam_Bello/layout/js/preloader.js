(function( $ ) {// jscs:ignore validateLineBreaks

    'use strict';

    function PagePreloader() {

        $( '#page-loader .page-loader-inner' ).delay( 500 ).fadeIn( 10, function() {
            $( this ).fadeOut( 500, function() {
                $( '#page-loader' ).fadeOut( 500 );
            });
        });

    }

    jQuery( window ).load(function( $ ) {
        PagePreloader();
    });

})( window.jQuery );
