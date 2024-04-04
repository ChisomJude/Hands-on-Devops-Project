<?php
$image_logo                                = get_theme_mod( 'pixova_lite_image_logo', esc_url( get_template_directory_uri() . '/layout/images/pixova-lite-img-logo.png' ) );
$pixova_lite_woocommerce_show_header_image = get_theme_mod( 'pixova_lite_woocommerce_show_header_image', 'show' );
$pixova_lite_woocommerce_header_image      = get_theme_mod( 'pixova_lite_woocommerce_header_image', esc_url( get_template_directory_uri() . '/layout/images/header-bg.jpg' ) );
$pixova_lite_woocommerce_title             = get_theme_mod( 'pixova_lite_woocommerce_title', __( 'WooCommerce', 'pixova-lite' ) );
$pixova_lite_woocommerce_description       = get_theme_mod( 'pixova_lite_woocommerce_description', esc_html__( 'We have the best products.', 'pixova-lite' ) );
?>
<header id="header-wrap">
	<div class="container header clearfix woo">
		<div class="row">
			<div class="col-md-12">
				<?php do_action( 'pixova_lite_logo' ); ?>
				<a id="nav-expander" class="pull-right" href="#">
					<i class="fa fa-bars fa-lg white"></i>
				</a>
				<?php
				if ( $image_logo ) {
					$main_navigation_class = 'main-navigation logo-image';
				} else {
					$main_navigation_class = 'main-navigation';
				}
				?>
				<nav class="<?php echo $main_navigation_class; ?>">
					<?php
					$menu_args = array(
						'theme_location' => 'primary',
						'fallback_cb'    => 'pixova_lite_fallback_cb',
					);
					echo wp_nav_menu( $menu_args );
					?>
				</nav><!--/.main-navigation.main-nav-single-project.visible-->
			</div><!--/.col-md-12-->
		</div><!--/.row-->
	</div><!--/.container.header-.clearfix-->
	<div class="offset-canvas-mobile">
		<nav class="mobile-nav-holder">
			<a href="#" class="close-btn mobile-nav-close-btn"><span class="fa fa-close"></span></a>
			<div class="mobile-nav">
				<?php
				$menu_args = array(
					'theme_location' => 'primary',
					'fallback_cb'    => 'pixova_lite_fallback_cb',
				);
				echo wp_nav_menu( $menu_args );
				?>
			</div><!--/.mobile-nav-->
		</nav><!--/.mobile-nav-holder-->
	</div><!--/.offset-canvas-mobile-->
</header><!--/#header-wrap-->

<?php if ( 'show' == $pixova_lite_woocommerce_show_header_image ) { ?>
	<section id="intro" class="blog-intro">
		<div class="parallax-bg-container">
			<?php if ( $pixova_lite_woocommerce_header_image ) { ?>
				<div class="parallax-bg-image" data-image-source="<?php echo esc_url( $pixova_lite_woocommerce_header_image ); ?>"></div>
			<?php } else { ?>
				<div class="parallax-bg-image" data-image-source="<?php echo get_template_directory_uri(); ?>/layout/images/header-bg.jpg"></div>
			<?php } ?>
		</div><!--/.parallax-bg-container-->
		<div id="intro-holder" class="container">
			<div class="intro-content parallax-text-fade">
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
							<?php if ( $pixova_lite_woocommerce_title ) { ?>
								<h1 class="intro-title"><?php echo wp_kses_post( $pixova_lite_woocommerce_title ); ?></h1>
							<?php } ?>
							<?php if ( $pixova_lite_woocommerce_description ) { ?>
								<p class="intro-tagline"><?php echo wp_kses_post( $pixova_lite_woocommerce_description ); ?></p>
							<?php } ?>
						</div><!--/.text-center-->
					</div><!--/.col-md-12-->
				</div><!--/.row-->
			</div><!--/.intro-content.parallax-text-fade-->
		</div><!--/.container-->
	</section><!--/#intro.blog-intro-->
<?php
} // End if().
?>
