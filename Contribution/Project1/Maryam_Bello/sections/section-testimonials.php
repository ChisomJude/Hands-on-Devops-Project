<?php

$pixova_lite_section_title     = get_theme_mod( 'pixova_lite_testimonial_section_title' );
$pixova_lite_section_sub_title = get_theme_mod( 'pixova_lite_testimonial_section_sub_title' );

// Testimonial #1
$pixova_lite_testimonial_1_person_name        = get_theme_mod( 'pixova_lite_testimonial_1_person_name' );
$pixova_lite_testimonial_1_person_description = get_theme_mod( 'pixova_lite_testimonial_1_person_description' );

# Image Manipulation
$pixova_lite_testimonial_1_person_image_customizer = get_theme_mod( 'pixova_lite_testimonial_1_person_image' );
$pixova_lite_testimonial_1_person_image            = pixova_lite_get_customizer_image_by_url( $pixova_lite_testimonial_1_person_image_customizer, 'thumbnail' );

# For default images, we don't have an ID stored
if ( ! $pixova_lite_testimonial_1_person_image ) {
	$pixova_lite_testimonial_1_person_image = $pixova_lite_testimonial_1_person_image_customizer;
}

// Testimonial #2
$pixova_lite_testimonial_2_person_name        = get_theme_mod( 'pixova_lite_testimonial_2_person_name' );
$pixova_lite_testimonial_2_person_description = get_theme_mod( 'pixova_lite_testimonial_2_person_description' );

# Image Manipulation
$pixova_lite_testimonial_2_person_image_customizer = get_theme_mod( 'pixova_lite_testimonial_2_person_image' );
$pixova_lite_testimonial_2_person_image            = pixova_lite_get_customizer_image_by_url( $pixova_lite_testimonial_2_person_image_customizer, 'thumbnail' );

if ( ! $pixova_lite_testimonial_2_person_image ) {
	$pixova_lite_testimonial_2_person_image = $pixova_lite_testimonial_2_person_image_customizer;
}

// Testimonial #3
$pixova_lite_testimonial_3_person_name        = get_theme_mod( 'pixova_lite_testimonial_3_person_name' );
$pixova_lite_testimonial_3_person_description = get_theme_mod( 'pixova_lite_testimonial_3_person_description' );

# Image Manipulation
$pixova_lite_testimonial_3_person_image_customizer = get_theme_mod( 'pixova_lite_testimonial_3_person_image' );
$pixova_lite_testimonial_3_person_image            = pixova_lite_get_customizer_image_by_url( $pixova_lite_testimonial_3_person_image_customizer, 'thumbnail' );

if ( ! $pixova_lite_testimonial_3_person_image ) {
	$pixova_lite_testimonial_3_person_image = $pixova_lite_testimonial_3_person_image_customizer;
}

// Testimonial #4
$pixova_lite_testimonial_4_person_name        = get_theme_mod( 'pixova_lite_testimonial_4_person_name' );
$pixova_lite_testimonial_4_person_description = get_theme_mod( 'pixova_lite_testimonial_4_person_description' );

# Image Manipulation
$pixova_lite_testimonial_4_person_image_customizer = get_theme_mod( 'pixova_lite_testimonial_4_person_image' );
$pixova_lite_testimonial_4_person_image            = pixova_lite_get_customizer_image_by_url( $pixova_lite_testimonial_4_person_image_customizer, 'thumbnail' );

if ( ! $pixova_lite_testimonial_4_person_image ) {
	$pixova_lite_testimonial_4_person_image = $pixova_lite_testimonial_4_person_image_customizer;
}

// Testimonial #5
$pixova_lite_testimonial_5_person_name        = get_theme_mod( 'pixova_lite_testimonial_5_person_name' );
$pixova_lite_testimonial_5_person_description = get_theme_mod( 'pixova_lite_testimonial_5_person_description' );

# Image Manipulation
$pixova_lite_testimonial_5_person_image_customizer = get_theme_mod( 'pixova_lite_testimonial_5_person_image' );
$pixova_lite_testimonial_5_person_image            = pixova_lite_get_customizer_image_by_url( $pixova_lite_testimonial_5_person_image_customizer, 'thumbnail' );

if ( ! $pixova_lite_testimonial_5_person_image ) {
	$pixova_lite_testimonial_5_person_image = $pixova_lite_testimonial_5_person_image_customizer;
}

$pixova_lite_no_of_testimonials = 0;

if ( isset( $pixova_lite_testimonial_1_person_image ) && ! empty( $pixova_lite_testimonial_1_person_image ) ) {
	$pixova_lite_no_of_testimonials++;
}

if ( isset( $pixova_lite_testimonial_2_person_image ) && ! empty( $pixova_lite_testimonial_2_person_image ) ) {
	$pixova_lite_no_of_testimonials++;
}

if ( 1 == $pixova_lite_no_of_testimonials ) {
	$pixova_lite_wrapper_class = '';
} elseif ( $pixova_lite_no_of_testimonials > 1 ) {
	$pixova_lite_wrapper_class = 'owlCarousel big-testimonial';
}

if ( 0 == $pixova_lite_no_of_testimonials && '' == $pixova_lite_section_title && '' == $pixova_lite_section_sub_title ) {
	return;
}

echo '<section class="has-padding" id="testimonials">';
	echo '<div class="container">';
if ( '' != $pixova_lite_section_title || '' != $pixova_lite_section_sub_title ) {
	echo '<div class="row">';
	echo '<div class="text-center section-heading">';
	echo '<h2 class="light-section-heading">';
		echo wp_kses_post( $pixova_lite_section_title );
	echo '</h2>';
	echo '<div class="section-sub-heading">' . wp_kses_post( $pixova_lite_section_sub_title ) . '</div>';
	echo '</div><!--/.text-center-->';
	echo '</div><!--/.row-->';
}
		echo '<div class="row">';

			echo '<div class="' . $pixova_lite_wrapper_class . ' col-lg-12">';

if ( isset( $pixova_lite_testimonial_1_person_image ) && ! empty( $pixova_lite_testimonial_1_person_image ) ) {
	echo '<div class="pixova-lite-testimonial-1">';

	echo '<div class="media">';
	echo '<div class="media-top align-center">';

	if ( $pixova_lite_testimonial_1_person_image ) {
		echo '<img width="138" height="138" class="testimonials-picture" src="' . esc_url( $pixova_lite_testimonial_1_person_image ) . '" alt="' . ( ( $pixova_lite_testimonial_1_person_name ) ? esc_attr( $pixova_lite_testimonial_1_person_name ) : '' ) . '">';
	}

	echo '</div><!--/.media-left.media-middle-->';

	echo '<div class="media-body">';

	echo '<p class="align-center">';
	if ( isset( $pixova_lite_testimonial_1_person_description ) && ! empty( $pixova_lite_testimonial_1_person_description ) ) {

		echo wp_kses_post( $pixova_lite_testimonial_1_person_description );

	} else {
		echo __( 'Please enter testimonial text', 'pixova-lite' );
	}
	echo '</p><!--/.align-center-->';
	echo '<div class="media-heading align-center">';
	if ( isset( $pixova_lite_testimonial_1_person_name ) && ! empty( $pixova_lite_testimonial_1_person_name ) ) {
		echo '<span class="pixova-person-name">' . wp_kses_post( $pixova_lite_testimonial_1_person_name ) . '</span>';
		echo ' - ';
	} else {
		echo __( 'Please enter testimonial person name.', 'pixova-lite' );
	}

	echo '</div><!--/.media-heading-->';
	echo '</div><!--/.media-body-->';
	echo '</div><!--/.media-->';
	echo '</div>';
}// End if().

if ( isset( $pixova_lite_testimonial_2_person_image ) && ! empty( $pixova_lite_testimonial_2_person_image ) ) {
	echo '<div class="pixova-lite-testimonial-2">';

	echo '<div class="media">';
	echo '<div class="media-top align-center">';

	if ( $pixova_lite_testimonial_2_person_image ) {
		echo '<img width="138" height="138" class="testimonials-picture" src="' . esc_url( $pixova_lite_testimonial_2_person_image ) . '" alt="' . ( ( $pixova_lite_testimonial_2_person_name ) ? esc_attr( $pixova_lite_testimonial_2_person_name ) : '' ) . '">';
	}

	echo '</div><!--/.media-left.media-middle-->';
	echo '<div class="media-body">';
	echo '<p class="align-center">';
	if ( isset( $pixova_lite_testimonial_2_person_description ) && ! empty( $pixova_lite_testimonial_2_person_description ) ) {

		echo wp_kses_post( $pixova_lite_testimonial_2_person_description );

	} else {
		echo __( 'Please enter testimonial text', 'pixova-lite' );
	}
	echo '</p>';
	echo '<div class="media-heading align-center">';
	if ( isset( $pixova_lite_testimonial_2_person_name ) && ! empty( $pixova_lite_testimonial_2_person_name ) ) {
		echo '<span class="pixova-person-name">' . wp_kses_post( $pixova_lite_testimonial_2_person_name ) . '</span>';
		echo ' - ';
	} else {
		echo __( 'Please enter testimonial person name.', 'pixova-lite' );
	}

	echo '</div><!--/.media-heading-->';
	echo '</div><!--/.media-body-->';
	echo '</div><!--/.media-->';
	echo '</div>';
}// End if().

if ( isset( $pixova_lite_testimonial_3_person_image ) && ! empty( $pixova_lite_testimonial_3_person_image ) ) {
	echo '<div class="pixova-lite-testimonial-3">';

	echo '<div class="media">';
	echo '<div class="media-top align-center">';

	if ( $pixova_lite_testimonial_3_person_image ) {
		echo '<img width="138" height="138" class="testimonials-picture" src="' . esc_url( $pixova_lite_testimonial_3_person_image ) . '" alt="' . ( ( $pixova_lite_testimonial_3_person_name ) ? esc_attr( $pixova_lite_testimonial_3_person_name ) : '' ) . '">';
	}

	echo '</div><!--/.media-left.media-middle-->';
	echo '<div class="media-body">';
	echo '<p class="align-center">';
	if ( isset( $pixova_lite_testimonial_3_person_description ) && ! empty( $pixova_lite_testimonial_3_person_description ) ) {

		echo wp_kses_post( $pixova_lite_testimonial_3_person_description );

	} else {
		echo __( 'Please enter testimonial text', 'pixova-lite' );
	}
	echo '</p>';
	echo '<div class="media-heading align-center">';
	if ( isset( $pixova_lite_testimonial_3_person_name ) && ! empty( $pixova_lite_testimonial_3_person_name ) ) {
		echo '<span class="pixova-person-name">' . wp_kses_post( $pixova_lite_testimonial_3_person_name ) . '</span>';
		echo ' - ';
	} else {
		echo __( 'Please enter testimonial person name.', 'pixova-lite' );
	}

	echo '</div><!--/.media-heading-->';
	echo '</div><!--/.media-body-->';
	echo '</div><!--/.media-->';
	echo '</div>';
}// End if().

if ( isset( $pixova_lite_testimonial_4_person_image ) && ! empty( $pixova_lite_testimonial_4_person_image ) ) {
	echo '<div  class="pixova-lite-testimonial-4">';
	echo '<div class="media">';
	echo '<div class="media-top align-center">';

	if ( $pixova_lite_testimonial_4_person_image ) {
		echo '<img width="138" height="138" class="testimonials-picture" src="' . esc_url( $pixova_lite_testimonial_4_person_image ) . '" alt="' . ( ( $pixova_lite_testimonial_4_person_name ) ? esc_attr( $pixova_lite_testimonial_4_person_name ) : '' ) . '">';
	}

	echo '</div><!--/.media-left.media-middle-->';
	echo '<div class="media-body">';
	echo '<p class="align-center">';
	if ( isset( $pixova_lite_testimonial_4_person_description ) && ! empty( $pixova_lite_testimonial_4_person_description ) ) {

		echo wp_kses_post( $pixova_lite_testimonial_4_person_description );

	} else {
		echo __( 'Please enter testimonial text', 'pixova-lite' );
	}
	echo '</p>';
	echo '<div class="media-heading align-center">';
	if ( isset( $pixova_lite_testimonial_4_person_name ) && ! empty( $pixova_lite_testimonial_4_person_name ) ) {
		echo '<span class="pixova-person-name">' . wp_kses_post( $pixova_lite_testimonial_4_person_name ) . '</span>';
		echo ' - ';
	} else {
		echo __( 'Please enter testimonial person name.', 'pixova-lite' );
	}

	echo '</div><!--/.media-heading-->';

	echo '</div><!--/.media-body-->';
	echo '</div><!--/.media-->';
	echo '</div>';
}// End if().

if ( isset( $pixova_lite_testimonial_5_person_image ) && ! empty( $pixova_lite_testimonial_5_person_image ) ) {
	echo '<div class="pixova-lite-testimonial-5">';

	echo '<div class="media">';
	echo '<div class="media-top align-center">';

	if ( $pixova_lite_testimonial_5_person_image ) {
		echo '<img class="testimonials-picture" src="' . esc_url( $pixova_lite_testimonial_5_person_image ) . '" alt="' . ( ( $pixova_lite_testimonial_5_person_name ) ? esc_attr( $pixova_lite_testimonial_5_person_name ) : '' ) . '">';
	}

	echo '</div><!--/.media-left.media-middle-->';
	echo '<div class="media-body">';
	echo '<p class="align-center">';
	if ( isset( $pixova_lite_testimonial_5_person_description ) && ! empty( $pixova_lite_testimonial_5_person_description ) ) {

		echo wp_kses_post( $pixova_lite_testimonial_5_person_description );

	} else {
		echo __( 'Please enter testimonial text', 'pixova-lite' );
	}
	echo '</p>';
	echo '<div class="media-heading align-center">';
	if ( isset( $pixova_lite_testimonial_5_person_name ) && ! empty( $pixova_lite_testimonial_5_person_name ) ) {
		echo '<span class="pixova-person-name">' . wp_kses_post( $pixova_lite_testimonial_5_person_name ) . '</span>';
		echo ' - ';
	} else {
		echo __( 'Please enter testimonial person name.', 'pixova-lite' );
	}

	echo '</div><!--/.media-heading-->';
	echo '</div><!--/.media-body-->';
	echo '</div><!--/.media-->';
	echo '</div>';
}// End if().
			echo '</div><!--/owl-carousel-->';
		echo '</div><!--/.row-->';
	echo '</div><!--/.container-->';
echo '</section><!--/ SECTION -->';
