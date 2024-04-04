<?php
/**
 *  Next compatible functionality: over 4.4.2
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4.2', '>' ) ) {
	// Add Image Size
	add_image_size( 'pixova-lite-custom-logo', 141, 30, true );

	// Add Theme Support: Custom Logo
	add_theme_support( 'custom-logo', array(
		'size' => 'pixova-lite-custom-logo',
	) );

	// If a logo has been set previously, update to use logo feature introduced in WordPress 4.5
	if ( function_exists( 'the_custom_logo' ) && get_theme_mod( 'pixova_lite_image_logo', false ) ) {
		$logo = attachment_url_to_postid( get_theme_mod( 'pixova_lite_image_logo', false ) );

		if ( is_int( $logo ) ) {
			set_theme_mod( 'custom_logo', attachment_url_to_postid( get_theme_mod( 'pixova_lite_image_logo', false ) ) );
		}

		remove_theme_mod( 'pixova_lite_image_logo' );
	}

	// Logo
	add_action( 'pixova_lite_logo', 'pixova_lite_logo_over_442', 1 );
	function pixova_lite_logo_over_442() {
		$text_logo  = esc_html( get_option( 'blogname' ) );
		$image_logo = get_theme_mod( 'pixova_lite_image_logo', false );

		$output = '';

		if ( function_exists( 'has_custom_logo' ) ) {
			if ( has_custom_logo() ) {
				$output .= get_custom_logo();
			} elseif ( $image_logo ) {
				$output .= '<a class="logo" href="' . esc_url( get_site_url() ) . '"><img src="' . esc_url( $image_logo ) . '" alt="' . esc_attr( get_bloginfo( 'title' ) ) . '" title="' . esc_attr( get_bloginfo( 'title' ) ) . '" /></a>';
			} else {
				$output .= '<a class="logo" href="' . esc_url( get_site_url() ) . '">' . esc_html( $text_logo ) . '</a>';
			}
		}
		echo $output;
	}

	// Register Customizer
	add_action( 'customize_register', 'pixova_lite_customize_register_442', 50 );
	function pixova_lite_customize_register_442( $wp_customize ) {
		// Get Setting
		$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';

		// Remove Setting
		$wp_customize->remove_setting( 'pixova_lite_image_logo' );

		// Remove Control
		$wp_customize->remove_control( 'pixova_lite_image_logo' );
	}
}// End if().
