<?php

$pixova_lite_section_title     = get_theme_mod( 'pixova_lite_about_section_title' );
$pixova_lite_section_sub_title = get_theme_mod( 'pixova_lite_about_section_sub_title' );

// Text blocks
$pixova_lite_section_text_block      = get_theme_mod( 'pixova_lite_about_section_textarea' );
$pixova_lite_section_text_blockquote = get_theme_mod( 'pixova_lite_about_section_blockquote' );


// Section #1 Chart
$pixova_lite_section_1_chart_heading     = get_theme_mod( 'pixova_lite_about_section_chart_1_heading' );
$pixova_lite_section_1_chart_percentage  = get_theme_mod( 'pixova_lite_about_section_chart_1_percentage' );
$pixova_lite_section_1_chart_bar_color   = get_theme_mod( 'pixova_lite_about_section_chart_1_bar_color' );
$pixova_lite_section_1_chart_track_color = get_theme_mod( 'pixova_lite_about_section_chart_1_track_color' );

// Section #2 Chart
$pixova_lite_section_2_chart_heading     = get_theme_mod( 'pixova_lite_about_section_chart_2_heading' );
$pixova_lite_section_2_chart_percentage  = get_theme_mod( 'pixova_lite_about_section_chart_2_percentage' );
$pixova_lite_section_2_chart_bar_color   = get_theme_mod( 'pixova_lite_about_section_chart_2_bar_color' );
$pixova_lite_section_2_chart_track_color = get_theme_mod( 'pixova_lite_about_section_chart_2_track_color' );

// Section #3 Chart
$pixova_lite_section_3_chart_heading     = get_theme_mod( 'pixova_lite_about_section_chart_3_heading' );
$pixova_lite_section_3_chart_percentage  = get_theme_mod( 'pixova_lite_about_section_chart_3_percentage' );
$pixova_lite_section_3_chart_bar_color   = get_theme_mod( 'pixova_lite_about_section_chart_3_bar_color' );
$pixova_lite_section_3_chart_track_color = get_theme_mod( 'pixova_lite_about_section_chart_3_track_color' );

// Section #4 Chart
$pixova_lite_section_4_chart_heading     = get_theme_mod( 'pixova_lite_about_section_chart_4_heading' );
$pixova_lite_section_4_chart_percentage  = get_theme_mod( 'pixova_lite_about_section_chart_4_percentage' );
$pixova_lite_section_4_chart_bar_color   = get_theme_mod( 'pixova_lite_about_section_chart_4_bar_color' );
$pixova_lite_section_4_chart_track_color = get_theme_mod( 'pixova_lite_about_section_chart_4_track_color' );

// Logic used to dynamically create the layout, based on how many charts are active
$pixova_lite_no_of_charts = 0;
$pixova_lite_cols         = '';
$pixova_lite_chart_size   = '';

if ( isset( $pixova_lite_section_1_chart_percentage ) && is_numeric( $pixova_lite_section_1_chart_percentage ) ) {
	$pixova_lite_no_of_charts++;
}

if ( isset( $pixova_lite_section_2_chart_percentage ) && is_numeric( $pixova_lite_section_2_chart_percentage ) ) {
	$pixova_lite_no_of_charts++;
}

if ( isset( $pixova_lite_section_3_chart_percentage ) && is_numeric( $pixova_lite_section_3_chart_percentage ) ) {
	$pixova_lite_no_of_charts++;
}

if ( isset( $pixova_lite_section_4_chart_percentage ) && is_numeric( $pixova_lite_section_4_chart_percentage ) ) {
	$pixova_lite_no_of_charts++;
}

if ( 1 == $pixova_lite_no_of_charts ) {
	$pixova_lite_cols       = 'col-md-offset-4 col-sm-offset-3 col-xs-offset-1 text-center';
	$pixova_lite_chart_size = 'col-md-4 col-sm-6 col-xs-10';
} elseif ( 2 == $pixova_lite_no_of_charts ) {
	$pixova_lite_cols       = 'col-md-offset-4 col-sm-offset-2 text-center';
	$pixova_lite_chart_size = 'col-md-4 col-sm-4 col-xs-12';
} elseif ( 3 == $pixova_lite_no_of_charts ) {
	$pixova_lite_cols       = 'col-md-offset-1 col-xs-12';
	$pixova_lite_chart_size = 'col-md-3 col-sm-4 col-xs-12';
} elseif ( 4 == $pixova_lite_no_of_charts ) {
	$pixova_lite_cols       = 'col-xs-12';
	$pixova_lite_chart_size = 'col-md-3 col-sm-6 col-xs-12';
}

if ( 0 == $pixova_lite_no_of_charts && '' == $pixova_lite_section_title && '' == $pixova_lite_section_sub_title && '' == $pixova_lite_section_text_block && '' == $pixova_lite_section_text_blockquote ) {
	return;
}

echo '<section class="has-padding text-center" id="about">';
	echo '<div class="container">';
		echo '<div class="row">';
			echo '<div class="section-heading text-center">';
				echo '<h2 class="light-section-heading">';
					echo wp_kses_post( $pixova_lite_section_title );
				echo '</h2>';
				echo '<div class="section-sub-heading">' . wp_kses_post( $pixova_lite_section_sub_title ) . '</div>';
			echo '</div><!--/.text-center-->';
		echo '</div><!--/.row-->';

		echo '<div class="row">';

if ( isset( $pixova_lite_section_text_block ) && ! empty( $pixova_lite_section_text_block ) ) {
	echo '<p class="about-text">';
	echo wp_kses(
		$pixova_lite_section_text_block,
		array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
			),
			'img'    => array(
				'alt'   => array(),
				'title' => array(),
				'src'   => array(),
				'class' => array(),
				'id'    => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
		)
	);
	echo '</p><!--/.about-text-->';
}

if ( isset( $pixova_lite_section_text_blockquote ) && ! empty( $pixova_lite_section_text_blockquote ) ) {
	echo '<blockquote>';
	echo '<p>';
	echo wp_kses(
		$pixova_lite_section_text_blockquote,
		array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
			),
			'img'    => array(
				'alt'   => array(),
				'title' => array(),
				'src'   => array(),
				'class' => array(),
				'id'    => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
		)
	);
	echo '</p>';
	echo '</blockquote>';
}

echo '<div class="pixova_lite_pie_chart_wrapper ' . $pixova_lite_cols . '">';

if ( isset( $pixova_lite_section_1_chart_percentage ) && is_numeric( $pixova_lite_section_1_chart_percentage ) ) {
	echo '<div class="pixova_lite_chart_1 ' . $pixova_lite_chart_size . '">';
	echo '<div class="pixova-chart" data-trackColor="' . esc_html( $pixova_lite_section_1_chart_track_color ) . '" data-barColor="' . esc_html( $pixova_lite_section_1_chart_bar_color ) . '" data-lineWidth="10" data-percent="' . esc_html( $pixova_lite_section_1_chart_percentage ) . '">';
	echo'<div class="pixova-pie-chart-custom-text">';
		echo esc_html( $pixova_lite_section_1_chart_percentage ) . '%';
	echo'</div><!--/.pixova-pie-chart-custom-text-->';
	echo '</div><!--/.pixova-chart-->';

	if ( isset( $pixova_lite_section_1_chart_heading ) ) {
		echo '<h4 class="pixova-heading pixova-heading-single-line text-center">';
		echo wp_kses_post( $pixova_lite_section_1_chart_heading );
		echo '</h4><!--/.pixova-heading-->';
	}

	echo '</div><!--/.col-md-->';
}

if ( isset( $pixova_lite_section_2_chart_percentage ) && is_numeric( $pixova_lite_section_2_chart_percentage ) ) {
	echo '<div class="pixova_lite_chart_2 ' . $pixova_lite_chart_size . '">';
	echo '<div class="pixova-chart" data-trackColor="' . esc_html( $pixova_lite_section_2_chart_track_color ) . '" data-barColor="' . esc_html( $pixova_lite_section_2_chart_bar_color ) . '" data-lineWidth="10" data-percent="' . esc_html( $pixova_lite_section_2_chart_percentage ) . '">';
	echo'<div class="pixova-pie-chart-custom-text">';
		echo esc_html( $pixova_lite_section_2_chart_percentage ) . '%';
	echo'</div><!--/.pixova-pie-chart-custom-text-->';
	echo '</div><!--/.pixova-chart-->';

	if ( isset( $pixova_lite_section_2_chart_heading ) ) {
		echo '<h4 class="pixova-heading pixova-heading-single-line text-center">';
		echo wp_kses_post( $pixova_lite_section_2_chart_heading );
		echo '</h4><!--/.pixova-heading-->';
	}
	echo '</div><!--/.col-md-->';
}

if ( isset( $pixova_lite_section_3_chart_percentage ) && is_numeric( $pixova_lite_section_3_chart_percentage ) ) {
	echo '<div class="pixova_lite_chart_3 ' . $pixova_lite_chart_size . '">';
	echo '<div class="pixova-chart" data-trackColor="' . esc_html( $pixova_lite_section_3_chart_track_color ) . '" data-barColor="' . esc_html( $pixova_lite_section_3_chart_bar_color ) . '" data-lineWidth="10" data-percent="' . esc_html( $pixova_lite_section_3_chart_percentage ) . '">';
		echo'<div class="pixova-pie-chart-custom-text">';
			echo esc_html( $pixova_lite_section_3_chart_percentage ) . '%';
		echo'</div><!--/.pixova-pie-chart-custom-text-->';
	echo '</div><!--/.pixova-chart-->';
	if ( isset( $pixova_lite_section_3_chart_heading ) ) {
		echo '<h4 class="pixova-heading pixova-heading-single-line text-center">';
		echo wp_kses_post( $pixova_lite_section_3_chart_heading );
		echo '</h4><!--/.pixova-heading-->';
	}
	echo '</div><!--/.col-md-->';
}


if ( isset( $pixova_lite_section_4_chart_percentage ) && is_numeric( $pixova_lite_section_4_chart_percentage ) ) {
	echo '<div class="pixova_lite_chart_4 ' . $pixova_lite_chart_size . '">';
	echo '<div class="pixova-chart" data-trackColor="' . esc_html( $pixova_lite_section_4_chart_track_color ) . '" data-barColor="' . esc_html( $pixova_lite_section_4_chart_bar_color ) . '" data-lineWidth="10" data-percent="' . esc_html( $pixova_lite_section_4_chart_percentage ) . '">';
	echo'<div class="pixova-pie-chart-custom-text">';
		echo esc_html( $pixova_lite_section_4_chart_percentage ) . '%';
	echo'</div><!--/.pixova-pie-chart-custom-text-->';
	echo '</div><!--/.pixova-chart-->';
	if ( isset( $pixova_lite_section_4_chart_heading ) ) {
		echo '<h4 class="pixova-heading pixova-heading-single-line text-center">';
		echo wp_kses_post( $pixova_lite_section_4_chart_heading );
		echo '</h4><!--/.pixova-heading-->';
	}
	echo '</div><!--/.col-md-->';
}
echo '</div><!--/.pixova-pie-chart-wrapper-->';

		echo '<div class="clearfix"></div>';
		echo '</div><!--/.row-->';

	echo '</div><!--/.container-->';
echo '</section><!--/section-->';
