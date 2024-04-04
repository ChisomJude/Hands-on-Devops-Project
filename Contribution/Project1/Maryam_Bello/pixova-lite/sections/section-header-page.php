<?php
$image_logo = get_theme_mod( 'pixova_lite_image_logo', esc_url( get_template_directory_uri() . '/layout/images/pixova-lite-img-logo.png' ) );

echo '<!-- Header -->';
echo '<header id="header-wrap">';
	echo '<div class="container header clearfix">';
		echo '<div class="row">';
			echo '<div class="col-md-12">';

				do_action( 'pixova_lite_logo' );

				echo '<!-- menu icon -->';
				echo '<a id="nav-expander" class="pull-right" href="#">';
					echo '<i class="fa fa-bars fa-lg white"></i>';
				echo '</a>';

				echo '<!-- /menu icon -->';
				echo '<!-- main navigation -->';

if ( $image_logo ) {
	$main_navigation_class = 'main-navigation logo-image';
} else {
	$main_navigation_class = 'main-navigation';
}

				echo '<nav class="' . $main_navigation_class . '">';
					echo wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'fallback_cb'    => 'pixova_lite_fallback_cb',
						)
					);
					echo '</nav>';
					echo '</div>';
					echo '</div>';
					echo '</div>';

					echo '<!-- main navigation mobile -->';
					echo '<div class="offset-canvas-mobile">';
					echo '<nav class="mobile-nav-holder">';
					echo '<a href="#" class="close-btn mobile-nav-close-btn"><span class="fa fa-close"></span></a>';
					echo '<div class="mobile-nav">';
					echo wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'fallback_cb'    => 'pixova_lite_fallback_cb',
						)
					);
					echo '</div>';
					echo '</nav>';
					echo '</div>';
					echo '<!-- /main navigation mobile -->';
					echo '</header>';
					echo '<!-- /Header -->';


					echo '<section id="intro" class="blog-intro">';
					echo '<div class="parallax-bg-container">';


					if ( get_header_image() !== '' ) {
						echo '<div class="parallax-bg-image" data-image-source="' . get_header_image() . '"></div>';
					} else {
						echo '<div class="parallax-bg-image" data-image-source=' . get_template_directory_uri() . '/layout/images/header-bg.jpg"></div>';
					}

					echo '</div><!--/.parallax-bg-container-->';
					echo '<div class="container" id="intro-holder">';
					echo '<div class="intro-content parallax-text-fade">';
					echo '<div class="row">';
					echo '<div class="col-md-12">';
					echo '<div class="text-center">';

					if ( ! function_exists( 'is_woocommerce' ) ) {
						echo '<div class="pixova-date">' . get_the_date( get_option( 'date_format' ), $post->ID ) . '</div>';
					}

					echo '<h1 class="intro-title">' . esc_html( get_the_title() ) . '</h1>';
					echo '</div><!--/.text-center-->';
					echo '</div><!--/.col-md-12-->';
					echo '</div><!--/.row-->';
					echo '</div><!--/.intro-content.parallax-text-fade-->';
					echo '</div><!--/.container-->';
					echo '</section><!-- SECTION -->';
