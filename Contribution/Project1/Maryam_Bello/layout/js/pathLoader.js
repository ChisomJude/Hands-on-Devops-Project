( function( window ) {// jscs:ignore validateLineBreaks
	'use strict';

	function PathLoader( el ) {
		this.el = el;

		// Clear stroke
		this.el.style.strokeDasharray = this.el.style.strokeDashoffset = this.el.getTotalLength();
	}

	PathLoader.prototype._draw = function( val ) {
		this.el.style.strokeDashoffset = this.el.getTotalLength() * ( 1 - val );
	};

	PathLoader.prototype.setProgress = function( val, callback ) {
		this._draw( val );
		if ( callback && 'function' === typeof callback ) {

			// Give it a time (ideally the same like the transition time) so that the last progress increment animation is still visible.
			setTimeout( callback, 200 );
		}
	};

	PathLoader.prototype.setProgressFn = function( fn ) {
		if ( 'function' === typeof fn ) {
 fn( this );
 }
	};

	// Add to global namespace
	window.PathLoader = PathLoader;

})( window );

window.loader = new PathLoader( jQuery( '#ip-loader-circle' )[0] );
window.loaderProgress = 0.9;

jQuery( document ).ready(function() {

	function initLoader() {
        var progress = 0;
        var LoaderInterval = setInterval( function() {
            progress = Math.min( progress + Math.random() * 0.1, window.loaderProgress );
            window.loader.setProgress( progress );

            if ( 1 === progress ) {
                jQuery( '#awesome-loader' ).addClass( 'loaded' );
                jQuery( '#awesome-loader' ).removeClass( 'loading' );
                clearInterval( LoaderInterval );
            }
        }, 80 );
    }

    setTimeout(function() {
 initLoader();
 }, 900 );

});

jQuery( window ).load(function() {
    window.loaderProgress = 1;
});
