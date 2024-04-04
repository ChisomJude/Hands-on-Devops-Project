<?php

$pixova_lite_section_title     = get_theme_mod( 'pixova_lite_contact_section_title' );
$pixova_lite_section_sub_title = get_theme_mod( 'pixova_lite_contact_section_sub_title' );

// section args
$pixova_lite_contact_section_address = get_theme_mod( 'pixova_lite_address' );
$pixova_lite_contact_section_phone   = get_theme_mod( 'pixova_lite_phone' );
$pixova_lite_contact_section_email   = get_theme_mod( 'pixova_lite_email' );
$pixova_lite_contact_cf7_form        = get_theme_mod( 'pixova_lite_contact_section_cf7' );
$pixova_lite_contact_section_type    = get_theme_mod( 'pixova_lite_contact_section_type', 'contact-form-7' );

$pixova_lite_contact_first_heading  = get_theme_mod( 'pixova_lite_contact_first_heading' );
$pixova_lite_contact_second_heading = get_theme_mod( 'pixova_lite_contact_second_heading' );

if ( '' == $pixova_lite_section_title && '' == $pixova_lite_section_sub_title && '' == $pixova_lite_contact_section_address && '' == $pixova_lite_contact_section_phone && '' == $pixova_lite_contact_section_email && ( 'contact-form-7' == $pixova_lite_contact_section_type && '' == $pixova_lite_contact_cf7_form ) ) {
	return;
}

echo '<section class="has-padding" id="contact">';
	echo '<div class="container">';
if ( '' != $pixova_lite_section_title || '' != $pixova_lite_section_sub_title ) {
	echo '<div class="row">';
	echo '<div class="text-center section-heading">';
	echo '<h2 class="light-section-heading">';
		echo wp_kses_post( $pixova_lite_section_title );
	echo '</h2><!--/.section-heading.light-section-heading-->';
		echo '<div class="section-sub-heading">' . wp_kses_post( $pixova_lite_section_sub_title ) . '</div>';
	echo '</div><!--/.text-center-->';
	echo '</div><!--/.row-->';
}

		echo '<div class="row">';

		echo '<div class="col-md-3">';
			echo '<div class="pixova-contact-info">';
if ( '' != $pixova_lite_contact_first_heading ) {
	echo '<h3 class="address">' . wp_kses_post( $pixova_lite_contact_first_heading ) . '</h3>';
}
if ( '' != $pixova_lite_contact_section_address ) {
	echo '<p class="contact-info-details address"><span>' . wp_kses_post( $pixova_lite_contact_section_address ) . '</span></p>';
}
if ( '' != $pixova_lite_contact_second_heading ) {
	echo '<h3 class="support">' . wp_kses_post( $pixova_lite_contact_second_heading ) . '</h3>';
}
if ( '' != $pixova_lite_contact_section_phone ) {
	echo '<p class="contact-info-details-phone">' . __( 'Phone: ', 'pixova-lite' ) . '<span>' . wp_kses_post( $pixova_lite_contact_section_phone ) . '</span></p>';
}
if ( '' != $pixova_lite_contact_section_email ) {
	echo '<p class="contact-info-details-email">' . __( 'Email: ', 'pixova-lite' ) . '<span>' . wp_kses_post( $pixova_lite_contact_section_email ) . '</span></p>';
}

				echo '</div><!--/.contact-info-details-->';
			echo '</div><!--/.pixova-contact-info-->';
		//echo '</div><!--/.col-md-3-->';
		echo '<div class="col-md-9">';

		require_once ABSPATH . 'wp-admin/includes/plugin.php';

if ( 'contact-form-7' == $pixova_lite_contact_section_type && is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) && null != $pixova_lite_contact_cf7_form && 'default' != $pixova_lite_contact_cf7_form ) {
	$shortcode = '[contact-form-7 id="' . esc_html( $pixova_lite_contact_cf7_form ) . '"]';
	echo do_shortcode( $shortcode );
} elseif ( 'pirate-forms' == $pixova_lite_contact_section_type ) {
	echo do_shortcode( '[pirate_forms]' );
} ?>
<?php

		echo '</div><!--/.row-->';
	echo '</div><!--/.col-md-9-->';
	echo '</div><!--/.container-->';
echo '</section>';
