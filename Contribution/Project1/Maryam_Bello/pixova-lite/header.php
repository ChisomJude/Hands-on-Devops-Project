<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	global $wp_customize;
	$preloader_enabled = get_theme_mod( 'pixova_lite_preloader_enabled', 'preloader_enabled' );

	if ( ! isset( $wp_customize ) && 'preloader_enabled' == $preloader_enabled ) {
	?>

		<!-- New Site Preloader -->

		<div id="awesome-loader" class="loading">
			<div class="logo-holder">
				<?php do_action( 'pixova_lite_logo' ); ?>
			</div>
			<div class="loader-holder">
				<svg class="ip-inner" width="60px" height="60px" viewBox="0 0 80 80">
					<path class="ip-loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
					<path id="ip-loader-circle" class="ip-loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
				</svg>
			</div>
		</div>

		<!-- END Site Preloader -->

	<?php } ?>

	<div id="container" class="hfeed">

<?php

if ( 'posts' != get_option( 'show_on_front' ) && is_front_page() ) {
	get_template_part( 'sections/section', 'header' );
} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
	get_template_part( 'sections/section', 'header-woocommerce' );
} elseif ( is_search() || is_archive() || is_home() || is_page_template( 'page-templates/blog-template.php' ) || is_front_page() ) {
	get_template_part( 'sections/section','header-archive' );
} elseif ( is_page() || is_author() || is_404() ) {
	get_template_part( 'sections/section', 'header-page' );
} elseif ( is_single() ) {
	get_template_part( 'sections/section','header-single' );
} else {
	get_template_part( 'sections/section', 'header' );
}

?>
