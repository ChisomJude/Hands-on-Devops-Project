/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {

		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );

	} );

	wp.customize( 'blogdescription', function( value ) {

		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );

	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {

		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );

			} else {

				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );

			}
		} );

	} );

	// Company image logo
	wp.customize( 'pixova_lite_image_logo', function( value ) {
		value.bind( function( newval ) {

			if( newval !== '' ) {
				$( '.logo' ).empty();
				$( '.logo' ).append( '<img src="" alt="'+ wp.customize._value.pixova_lite_image_logo +'" title="'+ wp.customize._value.pixova_lite_image_logo +'" />' );
				$( '.logo img' ).attr( 'src', newval );
			} else {
				$( '.logo' ).text( wp.customize._value.blogname() );
			}

		} );
	} );

	// Company text logo
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
				$( '.logo' ).text( newval );
		} );
	} );

	// main CTA :: Button URL
	wp.customize( 'pixova_lite_intro_button_url', function( value ) {
		value.bind( function( newval ) {
				$( '.btn-cta-intro' ).attr('href', newval );
		} );
	} );

	// main CTA :: Button Background colour
	wp.customize( 'pixova_lite_intro_button_color', function( value ) {
		value.bind( function( newval ) {
				$( 'body .btn-cta-intro' ).css('background-color', newval );
		} );
	} );

	//
	// Pie Chart Section
	//

	// Chart - 1 :: Percentage
	wp.customize( 'pixova_lite_about_section_chart_1_percentage', function( value ) {
		value.bind( function( newval ) {
				$( '#about .pixova_lite_chart_1 .pixova-pie-chart-custom-text' ).text( newval + '%' );
		} );
	} );

	// Chart - 2 :: Percentage
	wp.customize( 'pixova_lite_about_section_chart_2_percentage', function( value ) {
		value.bind( function( newval ) {
				$( '#about .pixova_lite_chart_2 .pixova-pie-chart-custom-text' ).text( newval + '%' );
		} );
	} );

	// Chart - 3 :: Percentage
	wp.customize( 'pixova_lite_about_section_chart_3_percentage', function( value ) {
		value.bind( function( newval ) {
				$( '#about .pixova_lite_chart_3 .pixova-pie-chart-custom-text' ).text( newval + '%' );
		} );
	} );

	// Chart - 4 :: Percentage
	wp.customize( 'pixova_lite_about_section_chart_4_percentage', function( value ) {
		value.bind( function( newval ) {
				$( '#about .pixova_lite_chart_4 .pixova-pie-chart-custom-text' ).text( newval + '%' );
		} );
	} );

	//
	// Testimonials section
	//

	// Testimonial 1 :: Person Name
	wp.customize( 'pixova_lite_testimonial_1_person_name', function( value ) {
		value.bind( function( newval ) {
				$( '#testimonials .pixova-lite-testimonial-1 .media-heading span' ).html( newval );
		} );
	} );

	// Testimonial 1 :: Person Description
	wp.customize( 'pixova_lite_testimonial_1_person_description', function( value ) {
		value.bind( function( newval ) {
				$( '#testimonials .pixova-lite-testimonial-1 .media-body p' ).html( newval );
		} );
	} );

	// Testimonial 2 :: Person Name
	wp.customize( 'pixova_lite_testimonial_2_person_name', function( value ) {
	  value.bind( function( newval ) {
	      $( '#testimonials .pixova-lite-testimonial-2 .media-heading span' ).html( newval );
	  } );
	} );

	// Testimonial 2 :: Person Description
	wp.customize( 'pixova_lite_testimonial_2_person_description', function( value ) {
	  value.bind( function( newval ) {
	      $( '#testimonials .pixova-lite-testimonial-2 .media-body p' ).html( newval );
	  } );
	} );

	// Testimonial 3 :: Person Name
	wp.customize( 'pixova_lite_testimonial_3_person_name', function( value ) {
	  value.bind( function( newval ) {
	      $( '#testimonials .pixova-lite-testimonial-3 .media-heading span' ).html( newval );
	  } );
	} );

	// Testimonial 3 :: Person Description
	wp.customize( 'pixova_lite_testimonial_3_person_description', function( value ) {
	  value.bind( function( newval ) {
	      $( '#testimonials .pixova-lite-testimonial-3 .media-body p' ).html( newval );
	  } );
	} );

	// Testimonial 4 :: Person Name
	wp.customize( 'pixova_lite_testimonial_4_person_name', function( value ) {
	  value.bind( function( newval ) {
	      $( '#testimonials .pixova-lite-testimonial-4 .media-heading span' ).html( newval );
	  } );
	} );

	// Testimonial 4 :: Person Description
	wp.customize( 'pixova_lite_testimonial_4_person_description', function( value ) {
	  value.bind( function( newval ) {
	      $( '#testimonials .pixova-lite-testimonial-4 .media-body p' ).html( newval );
	  } );
	} );

	// Testimonial 5 :: Person Name
	wp.customize( 'pixova_lite_testimonial_5_person_name', function( value ) {
	  value.bind( function( newval ) {
	      $( '#testimonials .pixova-lite-testimonial-5 .media-heading span' ).html( newval );
	  } );
	} );

	// Testimonial 5 :: Person Description
	wp.customize( 'pixova_lite_testimonial_5_person_description', function( value ) {
	  value.bind( function( newval ) {
	      $( '#testimonials .pixova-lite-testimonial-5 .media-body p' ).html( newval );
	  } );
	} );


	//
	// Latest News Section
	//

	// Section Button
	wp.customize( 'pixova_lite_news_section_button_text', function( value ) {
		value.bind( function( newval ) {
				$( '#news .btn.btn-cta-light' ).text( newval );
		} );
	} );

	/* Pie Chart Section Visibility */
	wp.customize( 'pixova_lite_about_visibility', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#about' ).addClass( 'customizer-display-none' );
			} else if ( newval == true ) {
				$( '#about' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Portfolio Section Visibility */
	wp.customize( 'pixova_lite_works_visibility', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#works' ).addClass( 'customizer-display-none' );
			} else if ( newval == true ) {
				$( '#works' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Testimonials Section Visibility */
	wp.customize( 'pixova_lite_testimonials_visibility', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#testimonials' ).addClass( 'customizer-display-none' );
			} else if ( newval == true ) {
				$( '#testimonials' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* News Section Visibility */
	wp.customize( 'pixova_lite_news_visibility', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#news' ).addClass( 'customizer-display-none' );
			} else if ( newval == true ) {
				$( '#news' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Tean Section Visibility */
	wp.customize( 'pixova_lite_team_visibility', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#team' ).addClass( 'customizer-display-none' );
			} else if ( newval == true ) {
				$( '#team' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	/* Contact Section Visibility */
	wp.customize( 'pixova_lite_contact_visibility', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '#contact' ).addClass( 'customizer-display-none' );
			} else if ( newval == true ) {
				$( '#contact' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	// Copyright message
	// Company text logo
	wp.customize( 'pixova_lite_copyright_enable', function( value ) {
		value.bind( function( newval ) {
			if( newval == false ) {
				$( '.pixova-lite-footer-theme-copyright' ).addClass( 'customizer-display-none' );
			} else if ( newval == true ) {
				$( '.pixova-lite-footer-theme-copyright' ).removeClass( 'customizer-display-none' );
			}
		} );
	} );

	wp.customize.bind('preview-ready', function () {
		wp.customize.preview.bind( 'section-highlight', function( data ) {
			var selectors = {
				'pixova_lite_panel_intro' : '#intro',
				'pixova_lite_panel_about' : '#about',
				'pixova_lite_panel_works' : '#works',
				'pixova_lite_panel_testimonials' : '#testimonials',
				'pixova_lite_panel_news' : '#news',
				'pixova_lite_panel_team' : '#team',
				'pixova_lite_panel_contact' : '#contact',
			};

			// Only on the front page.
			if ( ! $( selectors[ data.section ] ).length ) {
				return;
			}

			// When the section is expanded, show and scroll to the content placeholders, exposing the edit links.
			if ( true === data.expanded ) {
				$( 'html,body' ).animate({
	                scrollTop: $( selectors[ data.section ] ).offset().top
	            }, 1000 );
			}
		});
	});

} )( jQuery );
