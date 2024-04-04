(function( $ ) {// jscs:ignore validateLineBreaks

	'use strict';

	$( document ).ready(function() {
	    var owl, slides, headerTopSpacing = 0;

		/* Build & Animate the Pie Charts */
		function animatePieCharts() {

			if ( 'undefined' !== typeof $.fn.easyPieChart ) {

				//Noinspection CssInvalidPseudoSelector
				$( '.pixova-chart:in-viewport' ).each(function() {

					var $t = $( this ),
						n = $t.parent().width(),
						l = 'round';

					if ( undefined !== $t.attr( 'data-lineCap' ) ) {
						l = $t.attr( 'data-lineCap' );
					}

					// Set dimensions for Pie Charts
					$( this ).css({
						'width': n,
						'height': n,
						'line-height': n + 'px',
						'font-size': n / 3
					});

					// Animate
					$t.easyPieChart({
						animate: 1300,
						lineCap: l,
						lineWidth: $t.attr( 'data-lineWidth' ),
						size: n,
						barColor: $t.attr( 'data-barColor' ),
						trackColor: $t.attr( 'data-trackColor' ),
						scaleColor: 'transparent',
						onStep: function( from, to, percent ) {
							$( this.el ).find( '.pixova-pie-chart-custom-text' ).text( Math.round( percent ) + '%' );
						}

					});

				});
			}
		} // Function ends here

		// Owl Carousel - used to create carousels throughout the site
		// http://owlgraphic.com/owlcarousel/
		if ( 'undefined' !== typeof $.fn.owlCarousel ) {

			$( '.owlCarousel' ).each(function( index ) {

				var sliderSelector      = '#owlCarousel-' + $( this ).data( 'slider-id' ); // This is the slider selector
				var sliderItems         = $( this ).data( 'slider-items' );
				var sliderSpeed         = $( this ).data( 'slider-speed' );
				var sliderAutoPlay      = $( this ).data( 'slider-auto-play' );
				var sliderNavigation    = $( this ).data( 'slider-navigation' );
				var sliderPagination    = $( this ).data( 'slider-pagination' );
				var sliderSingleItem    = $( this ).data( 'slider-single-item' );

				//Conversion of 1 to true & 0 to false
				// auto play
				if ( 0 === sliderAutoPlay || 'false' === sliderAutoPlay ) {
					sliderAutoPlay = false;
				} else {
					sliderAutoPlay = true;
				}

				// Pager
				if ( 0 === sliderPagination || 'false' === sliderPagination ) {
					sliderPagination = false;
				} else {
					sliderPagination = true;
				}

				// Navigation
				if ( 0 === sliderNavigation || 'false' === sliderNavigation ) {
					sliderNavigation = false;
				} else {
					sliderNavigation = true;
				}

				// Custom Navigation events outside of the owlCarousel mark-up
				$( '.pixova-owl-next' ).on( 'click', function() {

					$( sliderSelector ).trigger( 'owl.next' );

				});
				$( '.pixova-owl-prev' ).on( 'click', function() {

					$( sliderSelector ).trigger( 'owl.prev' );

				});

				// Instantiate the slider with all the options
				$( sliderSelector ).owlCarousel({

					items: sliderItems,
					slideSpeed: sliderSpeed,
					navigation: sliderNavigation,
					autoPlay: sliderAutoPlay,
					pagination: sliderPagination,
					navigationText: [ // Custom navigation text (instead of bullets). navigationText : false to disable arrows / bullets
						'<i class=\'fa fa-angle-left\'></i>',
						'<i class=\'fa fa-angle-right\'></i>'
					]
				});

			});

		} // End

		// Owl Carousel - used to create carousels throughout the site
		// http://owlgraphic.com/owlcarousel/
		if ( 'undefined' !== typeof $.fn.owlCarousel ) {

			owl = $( '#pixova-twitter-carousel' );

			// Footer Twitter Widget
			if ( 0 !== owl.length ) {
				owl.owlCarousel({
					items: 1,
					singleItem: true,
					pagination: true,
					mouseDrag: false
				});
			}

				/* ==============================================================================================================
					Since we're using different owl carousel configurations for different breakpoints,
					we've decided against using CSS to re-style the nav icons and better leave it for Owl Carousel
					to handle the responsiveness part
				 ============================================================================================================== */

				if ( viewportSize.getWidth() > 768 ) {

					$( '.big-testimonial' ).each(function() {
						var owl3 = $( this );
						owl3.owlCarousel({
							items: 1,           // This variable allows you to set the maximum amount of items displayed at a time with the widest browser width
							navigation:true,    // Display "next" and "prev" buttons.
							pagination: false,  // No pagination
							navigationText: [   // Custom navigation text (instead of bullets). navigationText : false to disable arrows / bullets
								'<i class=\'fa fa-angle-left\'></i>',
								'<i class=\'fa fa-angle-right\'></i>'
							],
							singleItem: true
						});

					});

				} else {

					$( '.big-testimonial' ).each(function() {
						var owl3 = $( this );
						owl3.owlCarousel({
							items: 1,           // This variable allows you to set the maximum amount of items displayed at a time with the widest browser width
							navigation: false,    // Display "next" and "prev" buttons.
							pagination: true,  // No pagination
							singleItem: true
						});
					});

				}

				/*
				*  Custom Owl Carousel Navigation Events
				*
				*   Trigger Owl Carousel specific events when clicking on next / prev buttons
				*
				*   @see  http://owlgraphic.com/owlcarousel/#customizing (Custom Events)
				*/
				$( '.next' ).on( 'click', function() {
					owl.trigger( 'owl.next' );
				});
				$( '.prev' ).on( 'click', function() {
					owl.trigger( 'owl.prev' );
				});
		}

		if ( $( '.pixova-blogpost-wrapper' ).length ) {
			slides = $( '.pixova-blogpost-wrapper' ).data( 'slider-items' );
			$( '.pixova-blogpost-wrapper' ).owlCarousel({
				items: slides,
				navigation: true,
				pagination: false,
				navigationText: [
					'<i class=\'fa fa-angle-left\'></i>',
					'<i class=\'fa fa-angle-right\'></i>'
				]
			});
		}

		// SimplePlaceholder - polyfill for mimicking the HTML5 placeholder attribute using jQuery
		if ( 'undefined' !== typeof $.fn.simplePlaceholder ) {

			$( 'input[placeholder], textarea[placeholder]' ).simplePlaceholder();

		}

		// Parallax.js  -  a dirt simple parallax scrolling effect inspired by Spotify.com and implemented as a jQuery plugin.
		// https://pixelcog.github.io/parallax.js/
		if ( 'undefined' !== typeof $.fn.parallax ) {

			if ( '' !== $( '.parallax-bg-image' ).data( 'image-source' ) ) {

				$( '.parallax-bg-image' ).each(function() {

					var imageSource = $( this ).data( 'image-source' );

					$( this ).parallax({
						imageSrc: imageSource,
						iosFix: true,
						androidFix: true
					});
				});
			} // If check
		}

		// WOW JS - Uses animate.css and only animates element when they're in viewport
		// http://mynameismatthieu.com/WOW/docs.html
		// jscs:disable requireCamelCaseOrUpperCaseIdentifiers
		if ( 'animations_enabled' === pixova_lite_localization.animations_enabled ) {// jscs:ignore requireCamelCaseOrUpperCaseIdentifiers
		// jscs:enable requireCamelCaseOrUpperCaseIdentifiers
			new WOW().init();
		}

		/* ==========================================================================
		   When the window is scrolled, do
		   ========================================================================== */

		$( window ).scroll(function() {
			animatePieCharts();
		});

		// Sticky Header
		if ( jQuery( '#wpadminbar' ).length > 0 ) {
			headerTopSpacing = 32;
		}
		jQuery( '#header-wrap' ).sticky({
			topSpacing: headerTopSpacing,
			zIndex: 9
		});

	});

})( window.jQuery );

//Non jQuery plugins below
