<?php

$pixova_lite_section_title     = get_theme_mod( 'pixova_lite_work_section_title' );
$pixova_lite_section_sub_title = get_theme_mod( 'pixova_lite_work_section_sub_title' );

// Project #1

#image manipulation
$pixova_lite_project_1_image_customizer = get_theme_mod( 'pixova_lite_works_project_1_image' );
$pixova_lite_project_1_image            = pixova_lite_get_customizer_image_by_url( $pixova_lite_project_1_image_customizer, 'pixova-lite-recent-works-image' );

if ( ! $pixova_lite_project_1_image ) {
	$pixova_lite_project_1_image = $pixova_lite_project_1_image_customizer;
}

$pixova_lite_project_1_logo = get_theme_mod( 'pixova_lite_works_project_1_logo' );
$pixova_lite_project_1_url  = get_theme_mod( 'pixova_lite_works_project_1_url' );

// Project #2
$pixova_lite_project_2_image_customizer = get_theme_mod( 'pixova_lite_works_project_2_image' );
$pixova_lite_project_2_image            = pixova_lite_get_customizer_image_by_url( $pixova_lite_project_2_image_customizer, 'pixova-lite-recent-works-image' );

if ( ! $pixova_lite_project_2_image ) {
	$pixova_lite_project_2_image = $pixova_lite_project_2_image_customizer;
}

$pixova_lite_project_2_logo = get_theme_mod( 'pixova_lite_works_project_2_logo' );
$pixova_lite_project_2_url  = get_theme_mod( 'pixova_lite_works_project_2_url' );

// Project #3
$pixova_lite_project_3_image_customizer = get_theme_mod( 'pixova_lite_works_project_3_image' );
$pixova_lite_project_3_image            = pixova_lite_get_customizer_image_by_url( $pixova_lite_project_3_image_customizer, 'pixova-lite-recent-works-image' );

if ( ! $pixova_lite_project_3_image ) {
	$pixova_lite_project_3_image = $pixova_lite_project_3_image_customizer;
}

$pixova_lite_project_3_logo = get_theme_mod( 'pixova_lite_works_project_3_logo' );
$pixova_lite_project_3_url  = get_theme_mod( 'pixova_lite_works_project_3_url' );

// Project #4
$pixova_lite_project_4_image_customizer = get_theme_mod( 'pixova_lite_works_project_4_image' );
$pixova_lite_project_4_image            = pixova_lite_get_customizer_image_by_url( $pixova_lite_project_4_image_customizer, 'pixova-lite-recent-works-image' );

if ( ! $pixova_lite_project_4_image ) {
	$pixova_lite_project_4_image = $pixova_lite_project_4_image_customizer;
}

$pixova_lite_project_4_logo = get_theme_mod( 'pixova_lite_works_project_4_logo' );
$pixova_lite_project_4_url  = get_theme_mod( 'pixova_lite_works_project_4_url' );


/**
 * Logic used to dynamically create the layout, based on how many projects are active
**/
	$pixova_lite_no_of_projects = 0;
	$pixova_lite_cols           = '';
	$pixova_lite_project_size   = '';

if ( isset( $pixova_lite_project_1_image ) && ! empty( $pixova_lite_project_1_image ) ) {
	$pixova_lite_no_of_projects++;
}

if ( isset( $pixova_lite_project_2_image ) && ! empty( $pixova_lite_project_2_image ) ) {
	$pixova_lite_no_of_projects++;
}

if ( isset( $pixova_lite_project_3_image ) && ! empty( $pixova_lite_project_3_image ) ) {
	$pixova_lite_no_of_projects++;
}

if ( isset( $pixova_lite_project_4_image ) && ! empty( $pixova_lite_project_4_image ) ) {
	$pixova_lite_no_of_projects++;
}

if ( 1 == $pixova_lite_no_of_projects ) {
	$pixova_lite_cols         = 'col-lg-12 col-lg-offset-4';
	$pixova_lite_project_size = 'col-lg-4 col-md-4';
} elseif ( 2 == $pixova_lite_no_of_projects ) {
	$pixova_lite_cols         = 'col-lg-12 col-lg-offset-2';
	$pixova_lite_project_size = 'col-lg-4 col-md-4';
} elseif ( 3 == $pixova_lite_no_of_projects ) {
	$pixova_lite_cols         = 'col-lg-12';
	$pixova_lite_project_size = 'col-lg-4 col-md-4';
} elseif ( 4 == $pixova_lite_no_of_projects ) {
	$pixova_lite_cols         = 'col-xs-12';
	$pixova_lite_project_size = 'col-lg-3 col-md-3';
} elseif ( 0 == $pixova_lite_no_of_projects ) {
	return;
}

echo '<section id="works" class="has-padding">';
	echo '<div class="container">';
		echo '<div class="row">';
			echo '<div class="text-center section-heading">';
				echo '<h2 class="light-section-heading">';
					echo wp_kses_post( $pixova_lite_section_title );
				echo '</h2>';
		echo '<div class="section-sub-heading">' . wp_kses_post( $pixova_lite_section_sub_title ) . '</div>';
			echo '</div><!--/.text-center-->';
		echo '</div><!--/.row-->';

		echo '<div class="row">';
			echo '<div class="owlCarousel project-carousel">';
				echo '<div class="pixova-projects-wrapper ' . $pixova_lite_cols . '">';
if ( isset( $pixova_lite_project_1_image ) && ! empty( $pixova_lite_project_1_image ) ) {

	// start building the return string for project #1
	echo '<div class="work pixova_lite_project_1 ' . $pixova_lite_project_size . '">';

	// Sanitization
	$pixova_lite_main_image = esc_url( $pixova_lite_project_1_image );
	$pixova_lite_logo_image = esc_url( $pixova_lite_project_1_logo );

	echo '<img src="' . $pixova_lite_main_image . '" alt="' . __( 'Recent Work 1', 'pixova-lite' ) . '">';

	echo '<div class="logo-background">';
	if ( $pixova_lite_logo_image ) {
		echo '<img src="' . $pixova_lite_logo_image . '" alt="' . __( 'Recent Work 1', 'pixova-lite' ) . '">';
	}

	echo '</div>';

	echo '<div class="work-description">';
	echo '<a target="_blank" class="work-project-link" href="' . esc_url( $pixova_lite_project_1_url ) . '"><span class="work-description-icon fa fa-eye"><em>' . __( 'See project', 'pixova-lite' ) . '</em></span></a>';
	echo '</div>';

	echo '</div><!--/.work-->';
}

if ( isset( $pixova_lite_project_2_image ) && ! empty( $pixova_lite_project_2_image ) ) {
	// start building the return string for project #2
	echo '<div class="work pixova_lite_project_2 ' . $pixova_lite_project_size . '">';

	// Sanitization
	$pixova_lite_main_image = esc_url( $pixova_lite_project_2_image );
	$pixova_lite_logo_image = esc_url( $pixova_lite_project_2_logo );

	echo '<img src="' . $pixova_lite_main_image . '" alt="' . __( 'Recent Work 2', 'pixova-lite' ) . '">';

	echo '<div class="logo-background">';
	if ( $pixova_lite_logo_image ) {
		echo '<img src="' . $pixova_lite_logo_image . '" alt="' . __( 'Recent Work 2', 'pixova-lite' ) . '">';
	}

	echo '</div>';

	echo '<div class="work-description">';
	echo '<a target="_blank" class="work-project-link" href="' . esc_url( $pixova_lite_project_2_url ) . '"><span class="work-description-icon fa fa-eye"><em>' . __( 'See project', 'pixova-lite' ) . '</em></span></a>';
	echo '</div>';

	echo '</div><!--/.work-->';
}

if ( isset( $pixova_lite_project_3_image ) && ! empty( $pixova_lite_project_3_image ) ) {

	// start building the return string
	echo '<div class="work pixova_lite_project_3 ' . $pixova_lite_project_size . '">';

	$pixova_lite_main_image = esc_url( $pixova_lite_project_3_image );
	$pixova_lite_logo_image = esc_url( $pixova_lite_project_3_logo );

	echo '<img src="' . $pixova_lite_main_image . '" alt="' . __( 'Recent Work 3', 'pixova-lite' ) . '">';

	echo '<div class="logo-background">';
	if ( $pixova_lite_logo_image ) {
		echo '<img src="' . $pixova_lite_logo_image . '" alt="' . __( 'Recent Work 3', 'pixova-lite' ) . '">';
	}

	echo '</div>';

	echo '<div class="work-description">';
	echo '<a target="_blank" class="work-project-link" href="' . esc_url( $pixova_lite_project_3_url ) . '"><span class="work-description-icon fa fa-eye"><em>' . __( 'See project', 'pixova-lite' ) . '</em></span></a>';
	echo '</div>';

	echo '</div><!--/.work-->';
}

if ( isset( $pixova_lite_project_4_image ) && ! empty( $pixova_lite_project_4_image ) ) {
	// start building the return string
	echo '<div class="work pixova_lite_project_4 ' . $pixova_lite_project_size . '">';

	$pixova_lite_main_image = esc_url( $pixova_lite_project_4_image );
	$pixova_lite_logo_image = esc_url( $pixova_lite_project_4_logo );

	echo '<img src="' . $pixova_lite_main_image . '" alt="' . __( 'Recent Work 4', 'pixova-lite' ) . '">';

	echo '<div class="logo-background">';
	if ( $pixova_lite_logo_image ) {
		echo '<img src="' . $pixova_lite_logo_image . '" alt="' . __( 'Recent Work 4', 'pixova-lite' ) . '">';
	}

	echo '</div>';

	echo '<div class="work-description">';
	echo '<a target="_blank" class="work-project-link" href="' . esc_url( $pixova_lite_project_4_url ) . '"><span class="work-description-icon fa fa-eye"><em>' . __( 'See project', 'pixova-lite' ) . '</em></span></a>';
	echo '</div>';

	echo '</div><!--/.work-->';
}
				echo '</div><!--/.pixova-projects-wrapper-->';
			echo '</div><!--/owl-carousel-->';
		echo '</div> <!--/.row-->';
	echo '</div><!--/.container-->';
echo '</section><!--/#works.has-padding-->';
