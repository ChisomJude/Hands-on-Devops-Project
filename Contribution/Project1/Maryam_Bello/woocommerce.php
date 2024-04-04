<?php
/**
 *  The template for displaying WooCommerce.
 *
 *  @package WordPress
 *  @subpackage pixova-lite
 */
?>
<?php get_header(); ?>
<?php
$pixova_lite_woocommerce_show_sidebar_on_shop_page          = get_theme_mod( 'pixova_lite_woocommerce_show_sidebar_on_shop_page', 'show' );
$pixova_lite_woocommerce_show_sidebar_on_left_or_right_side = get_theme_mod( 'pixova_lite_woocommerce_show_sidebar_on_left_or_right_side', 'left' );
?>
<section class="has-padding">
	<div class="container">
		<div class="row">
			<?php if ( is_shop() ) { ?>
				<?php if ( 'show' == $pixova_lite_woocommerce_show_sidebar_on_shop_page && 'left' == $pixova_lite_woocommerce_show_sidebar_on_left_or_right_side ) { ?>
					<div class="col-md-3">
						<div class="pixova-blog-sidebar" style="margin-top: 0;">
							<?php
							if ( is_active_sidebar( 'woocommerce-sidebar' ) ) {
								dynamic_sidebar( 'woocommerce-sidebar' );
							} else {
								the_widget( 'WC_Widget_Cart', 'title=' . esc_html__( 'WooCommerce Title', 'pixova-lite' ) );
								the_widget( 'WC_Widget_Product_Categories', 'title=' . esc_html__( 'Product Categories', 'pixova-lite' ) );
							}
							?>
						</div><!--/.pixova-blog-sidebar-->
					</div><!--/.col-md-3-->
				<?php } ?>
				<div class="<?php echo 'show' == $pixova_lite_woocommerce_show_sidebar_on_shop_page ? 'col-md-9' : 'col-md-12'; ?>">
					<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">
							<?php woocommerce_content(); ?>
						</main><!-- #main -->
					</div><!-- #primary -->
				</div><!-- .content-left-wrap -->
				<?php if ( 'show' == $pixova_lite_woocommerce_show_sidebar_on_shop_page && 'right' == $pixova_lite_woocommerce_show_sidebar_on_left_or_right_side ) { ?>
					<div class="col-md-3">
						<div class="pixova-blog-sidebar" style="margin-top: 0;">
							<?php
							if ( is_active_sidebar( 'woocommerce-sidebar' ) ) {
								dynamic_sidebar( 'woocommerce-sidebar' );
							} else {
								the_widget( 'WC_Widget_Cart', 'title=' . esc_html__( 'WooCommerce Title', 'pixova-lite' ) );
								the_widget( 'WC_Widget_Product_Categories', 'title=' . esc_html__( 'Product Categories', 'pixova-lite' ) );
							}
							?>
						</div><!--/.pixova-blog-sidebar-->
					</div><!--/.col-md-3-->
				<?php } ?>
			<?php } else { ?>
				<div class="col-md-12">
					<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">
							<?php woocommerce_content(); ?>
						</main><!-- #main -->
					</div><!-- #primary -->
				</div><!-- .content-left-wrap -->
			<?php
} // End if().
			?>
		</div><!--/.row-->
	</div><!-- .container -->
</section><!--/.has-padding-->
<?php get_footer(); ?>
